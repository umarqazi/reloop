<?php


namespace App\Services;

use App\Forms\IForm;
use App\User;
use Cartalyst\Stripe\Exception\BadRequestException;
use Cartalyst\Stripe\Exception\CardErrorException;
use Cartalyst\Stripe\Exception\InvalidRequestException;
use Cartalyst\Stripe\Exception\NotFoundException;
use Cartalyst\Stripe\Exception\ServerErrorException;
use Cartalyst\Stripe\Exception\UnauthorizedException;
use Cartalyst\Stripe\Stripe;

class StripeService extends BaseService
{
    private $stripe;
    private $user;

    /**
     * StripeService constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->stripe = new Stripe(env('STRIPE_SECRET_KEY'));
        $this->user = new User();
    }



    /**
     * @inheritDoc
     */
    public function store(IForm $form)
    {

    }

    /**
     * @inheritDoc
     */
    public function findById($id)
    {
        // TODO: Implement findById() method.
    }

    /**
     * @inheritDoc
     */
    public function remove($id)
    {
        // TODO: Implement remove() method.
    }

    /**
     * @param $data
     * @author H.Bilal Saqib
     */
    public function addProduct($data){
        $product = $this->stripe->plans()->create([
            'product[name]'        => $data['name'],
            'amount'      => $data['price'],
            'currency'    => config('constants.CURRENCY'),
            'interval'    => config('constants.MONTHLY_SUBSCRIPTION')
        ]);
        return $product;
    }

    /**
     * Method: createCustomer
     * Send customer to stripe
     *
     * @param $data
     *
     * @return mixed
     */
    public function createCustomer($data)
    {
        $customer = $this->stripe->customers()->create([
            'email' => $data->email
        ]);

        return $customer['id'];
    }

    /**
     * Method: buyPlan
     *
     * @param $data
     *
     * @return mixed
     */
    public function buyPlan($data)
    {
        try {
            $authUser = $this->user->where('id', auth()->id())->first();
            $token = $this->__createToken($data);
            $this->__createCard($authUser->stripe_customer_id, $token);

            if (array_key_exists('plan_id', $data) && $data->subscription_type == ISubscriptionType::MONTHLY) {

                $makePayment = $this->__createSubscription($data, $authUser->stripe_customer_id);
            } else {

                $makePayment = $this->__makePayment($data, $authUser->stripe_customer_id);
            }
            return $makePayment;
        } catch (BadRequestException $e){

            $code = $e->getCode();
            $message = $e->getMessage();
            $type = $e->getErrorType();

        } catch (UnauthorizedException $e){

            $code = $e->getCode();
            $message = $e->getMessage();
            $type = $e->getErrorType();

        } catch (InvalidRequestException $e){

            $code = $e->getCode();
            $message = $e->getMessage();
            $type = $e->getErrorType();

        } catch (NotFoundException $e){

            $code = $e->getCode();
            $message = $e->getMessage();
            $type = $e->getErrorType();

        } catch (CardErrorException $e){

            $code = $e->getCode();
            $message = $e->getMessage();
            $type = $e->getErrorType();

        } catch (ServerErrorException $e){

            $code = $e->getCode();
            $message = $e->getMessage();
            $type = $e->getErrorType();
        }
        $responseData = [
            'stripe_error' => [
                $message
            ]
        ];
        return $responseData;
    }

    /**
     * Method: buyProduct
     *
     * @param $data
     *
     * @return mixed
     */
    public function buyProduct($data)
    {
        try {

            $authUser = $this->user->where('id', auth()->id())->first();

            $token = $this->__createToken($data);
            $this->__createCard($authUser->stripe_customer_id, $token);

            $makePayment = $this->__makePayment($data, $authUser->stripe_customer_id);

            return $makePayment;
        } catch (BadRequestException $e){

            $code = $e->getCode();
            $message = $e->getMessage();
            $type = $e->getErrorType();

        } catch (UnauthorizedException $e){

            $code = $e->getCode();
            $message = $e->getMessage();
            $type = $e->getErrorType();

        } catch (InvalidRequestException $e){

            $code = $e->getCode();
            $message = $e->getMessage();
            $type = $e->getErrorType();

        } catch (NotFoundException $e){

            $code = $e->getCode();
            $message = $e->getMessage();
            $type = $e->getErrorType();

        } catch (CardErrorException $e){

            $code = $e->getCode();
            $message = $e->getMessage();
            $type = $e->getErrorType();

        } catch (ServerErrorException $e){

            $code = $e->getCode();
            $message = $e->getMessage();
            $type = $e->getErrorType();
        }
        $responseData = [
            'stripe_error' => [
                $message
            ]
        ];
        return $responseData;
    }

    /**
     * Method: __createCard
     *
     * @param $customerId
     * @param $token
     * Create card for user on stripe
     *
     * @return mixed
     */
    private function __createCard($customerId, $token)
    {
        $card = $this->stripe
            ->cards()
            ->create( $customerId, $token );

        return $card['id'];
    }

    /**
     * Method: __createToken
     * Create token for user card on stripe
     *
     * @param $data
     *
     * @return mixed
     */
    private function __createToken($data)
    {
        $token = $this->stripe->tokens()->create([
            'card' => [
                'number'    => $data->card_number,
                'exp_month' => $data->exp_month,
                'cvc'       => $data->cvv,
                'exp_year'  => $data->exp_year
            ],
        ]);

        return $token['id'];
    }

    /**
     * Method: __createSubscription
     * Create subscription on stripe
     *
     * @param $data
     * @param $customerId
     *
     * @return mixed
     */
    private function __createSubscription($data, $customerId)
    {
        $subscription = $this->stripe->subscriptions()->create($customerId, [
            'plan' => $data->plan_id,
        ]);

        return $subscription;
    }

    /**
     * Method: __makePayment
     * Charge payment to user using stripe
     *
     * @param $data
     * @param $customerId
     *
     * @return mixed
     */
    private function __makePayment($data, $customerId)
    {
        $charge = $this->stripe->charges()->create([
            'customer' => $customerId,
            'currency' => config('constants.CURRENCY'),
            'amount'   => $data->total
        ]);

        return $charge;
    }
}

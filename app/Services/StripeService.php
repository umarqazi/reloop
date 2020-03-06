<?php


namespace App\Services;

use App\Forms\IForm;
use App\User;
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
     * Method: makePayment
     *
     * @param $data
     *
     * @return mixed
     */
    public function checkout($data)
    {
        $authUser = $this->user->where('id', auth()->id())->first();

        $token = $this->__createToken($data);
        $this->__createCard($authUser->stripe_customer_id, $token);

        if(array_key_exists('plan_id', $data)) {

            $paymentStatus = $this->__createSubscription($data, $authUser->stripe_customer_id);
        } else {

            $paymentStatus = $this->__makePayment($data, $authUser->stripe_customer_id);
        }
        return $paymentStatus;
    }

    private function __createCard($customerId, $token)
    {
        $card = $this->stripe
            ->cards()
            ->create( $customerId, $token );

        return $card['id'];
    }

    private function __createToken($data)
    {
        $token = $this->stripe->tokens()->create([
            'card' => [
                'number'    => $data['card_number'],
                'exp_month' => $data['exp_month'],
                'cvc'       => $data['cvc'],
                'exp_year'  => $data['exp_year'],
            ],
        ]);

        return $token['id'];
    }

    private function __createSubscription($data, $customerId)
    {
        $subscription = $this->stripe->subscriptions()->create($customerId, [
            'plan' => $data['plan_id'],
        ]);

        return $subscription;
    }

    private function __makePayment($data, $customerId)
    {
        $charge = $this->stripe->charges()->create([
            'customer' => $customerId,
            'currency' => config('constants.CURRENCY'),
            'amount'   => $data['price'],
        ]);

        return $charge;
    }
}

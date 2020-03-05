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
    public function makePayment($data)
    {
        $authUser = $this->user->where('id', auth()->id())->first();

        $token = $this->stripe->tokens()->create([
            'card' => [
                'number'    => $data['card_number'],
                'exp_month' => $data['exp_month'],
                'cvc'       => $data['cvc'],
                'exp_year'  => $data['exp_year'],
            ],
        ]);

        $this->stripe->cards()->create($authUser->stripe_customer_id, $token['id']);

        $subscription = $this->stripe->subscriptions()->create($authUser->stripe_customer_id, [
            'plan' => $data['plan_id'],
        ]);

        return $subscription;
    }
}

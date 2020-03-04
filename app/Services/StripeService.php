<?php


namespace App\Services;

use Cartalyst\Stripe\Stripe;

class StripeService
{
    private $stripe;

    /**
     * StripeService constructor.
     * @param Stripe $stripe
     */
    public function __construct()
    {
        $this->stripe = new Stripe(env('STRIPE_SECRET_KEY'));
    }

    /**
     * @param $data
     * @author H.Bilal Saqib
     */
    public function addProduct($data){
        $product = $this->stripe->plans()->create([
            'name'        => $data['name'],
            'amount'      => $data['price'],
            'currency'    => config('constants.CURRENCY'),
            'interval'    => 'month',
        ]);
        return $product;
    }

}

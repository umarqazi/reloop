<?php


namespace App\Forms\Checkout;
use App\Forms\BaseForm;

/**
 * Class BuyPlanForm
 *
 * @package   App\Forms\Checkout
 * @author    Faisal Raza <faisal.raza@gems.techverx.com>
 * @copyright 2020 Techverx.com All rights reserved.
 * @since     Mar 11, 2020
 * @project   reloop
 */
class BuyPlanForm extends BaseForm
{
    public $card_number;
    public $subscription_id;
    public $subscription_type;
    public $total;
    public $coupon_id;
    public $card_security_code;
    public $expiry_date;
    public $token_name;
    public $user_id;

    /**
     * @inheritDoc
     */
    public function toArray()
    {
        return [
            'card_number'             => $this->card_number,
            'subscription_id'         => $this->subscription_id,
            'subscription_type'       => $this->subscription_type,
            'total'                   => $this->total,
            'coupon_id'               => $this->coupon_id,
            'card_security_code'      => $this->card_security_code,
            'token_name'              => $this->token_name,
            'user_id'                 => $this->user_id,
            'expiry_date'             => $this->expiry_date,
        ];
    }

    /**
     * @inheritDoc
     */
    public function rules()
    {
        return [
            'card_number'             => 'required',
            'expiry_date'             => 'required',
            'card_security_code'      => 'required',
            'subscription_id'         => 'required',
            'subscription_type'       => 'required',
            'total'                   => 'required',
            'user_id'                 => 'required',
        ];
    }
}

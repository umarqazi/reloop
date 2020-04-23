<?php


namespace App\Forms\Checkout;
use App\Forms\BaseForm;

/**
 * Class RedeemPointForm
 *
 * @package   App\Forms\Checkout
 * @author    Faisal Raza <faisal.raza@gems.techverx.com>
 * @copyright 2020 Techverx.com All rights reserved.
 * @since     Apr 22, 2020
 * @project   reloop
 */
class RedeemPointForm extends BaseForm
{

    public $redeem_points;

    public function toArray()
    {
        return [
            'redeem_points' => $this->redeem_points
        ];
    }

    public function rules()
    {
        return [
            'redeem_points' => 'required|integer'
        ];
    }
}

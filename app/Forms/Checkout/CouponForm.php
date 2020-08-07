<?php


namespace App\Forms\Checkout;
use App\Forms\BaseForm;

/**
 * Class CouponForm
 *
 * @package   App\Forms\Checkout
 * @author    Faisal Raza <faisal.raza@gems.techverx.com>
 * @copyright 2020 Techverx.com All rights reserved.
 * @since     Mar 16, 2020
 * @project   reloop
 */
class CouponForm extends BaseForm
{
    public $coupon;
    public $category;

    /**
     * @inheritDoc
     */
    public function toArray()
    {
        return [
            'coupon' => $this->coupon,
            'category' => $this->category
        ];
    }

    /**
     * @inheritDoc
     */
    public function rules()
    {
        return [
            'coupon' => 'required',
            'category' => 'required',
        ];
    }
}

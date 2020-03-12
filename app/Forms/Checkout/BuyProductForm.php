<?php


namespace App\Forms\Checkout;
use App\Forms\BaseForm;

/**
 * Class BuyProductForm
 *
 * @package   App\Forms\Checkout
 * @author    Faisal Raza <faisal.raza@gems.techverx.com>
 * @copyright 2020 Techverx.com All rights reserved.
 * @since     Mar 11, 2020
 * @project   reloop
 */
class BuyProductForm extends BaseForm
{
    public $card_number;
    public $exp_month;
    public $cvc;
    public $exp_year;
    public $total;

    /**
     * @inheritDoc
     */
    public function toArray()
    {
        return [
            'card_number'   => $this->card_number,
            'exp_month'     => $this->exp_month,
            'cvc'           => $this->cvc,
            'exp_year'      => $this->exp_year,
            'total'         => $this->total
        ];
    }

    /**
     * @inheritDoc
     */
    public function rules()
    {
        return [
            'card_number' => 'required',
            'exp_month'   => 'required',
            'cvc'         => 'required',
            'exp_year'    => 'required',
        ];
    }
}

<?php


namespace App\Forms\Donation;
use App\Forms\BaseForm;

/**
 * Class DonationForm
 *
 * @package   App\Forms\Donation
 * @author    Faisal Raza <faisal.raza@gems.techverx.com>
 * @copyright 2020 Techverx.com All rights reserved.
 * @since     Apr 06, 2020
 * @project   reloop
 */
class DonationForm extends BaseForm
{
    public $product_id;

    /**
     * @inheritDoc
     */
    public function toArray()
    {
        return [
            'product_id' => $this->product_id
        ];
    }

    /**
     * @inheritDoc
     */
    public function rules()
    {
        return [
            'product_id' => 'required'
        ];
    }
}

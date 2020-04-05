<?php


namespace App\Forms\Donation;
use App\Forms\BaseForm;

/**
 * Class DonationProductForm
 *
 * @package   App\Forms\Donation
 * @author    Faisal Raza <faisal.raza@gems.techverx.com>
 * @copyright 2020 Techverx.com All rights reserved.
 * @since     Apr 06, 2020
 * @project   reloop
 */
class DonationProductForm extends BaseForm
{
    public $category_id;

    /**
     * @inheritDoc
     */
    public function toArray()
    {
        return [
            'category_id' => $this->category_id
        ];
    }

    /**
     * @inheritDoc
     */
    public function rules()
    {
        return [
            'category_id' => 'required'
        ];
    }
}

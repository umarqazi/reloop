<?php


namespace App\Forms\User;
use App\Forms\BaseForm;

/**
 * Class DefaultAddressForm
 *
 * @package   App\Forms\User
 * @author    Faisal Raza <faisal.raza@gems.techverx.com>
 * @copyright 2020 Techverx.com All rights reserved.
 * @since     Apr 02, 2020
 * @project   reloop
 */
class DefaultAddressForm extends BaseForm
{
    public $address_id;

    /**
     * @inheritDoc
     */
    public function toArray()
    {
        return [
            'address_id' => $this->address_id
        ];
    }

    /**
     * @inheritDoc
     */
    public function rules()
    {
        return [
            'address_id' => 'required'
        ];
    }
}

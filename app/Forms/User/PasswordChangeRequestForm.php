<?php


namespace App\Forms\User;
use App\Forms\BaseForm;

/**
 * Class PasswordChangeRequestForm
 *
 * @package   App\Forms\User
 * @author    Faisal Raza <faisal.raza@gems.techverx.com>
 * @copyright 2020 Techverx.com All rights reserved.
 * @since     Apr 13, 2020
 * @project   reloop
 */
class PasswordChangeRequestForm extends BaseForm
{
    public $email;

    /**
     * @inheritDoc
     */
    public function toArray()
    {
        return [
            'email' => $this->email
        ];
    }

    /**
     * @inheritDoc
     */
    public function rules()
    {
        return [
            'email' => 'required'
        ];
    }
}

<?php


namespace App\Forms\User;
use App\Forms\BaseForm;

/**
 * Class PasswordForgotForm
 *
 * @package   App\Forms\User
 * @author    Faisal Raza <faisal.raza@gems.techverx.com>
 * @copyright 2020 Techverx.com All rights reserved.
 * @since     Mar 12, 2020
 * @project   reloop
 */
class PasswordForgotForm extends BaseForm
{

    public $email;
    public $token;
    /**
     * @inheritDoc
     */
    public function toArray()
    {
        return [
            'email'     => $this->email,
        ];
    }

    /**
     * @inheritDoc
     */
    public function rules()
    {
        return [
            'email' => 'required|email',
        ];
    }
}

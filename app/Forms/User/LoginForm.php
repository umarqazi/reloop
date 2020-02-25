<?php


namespace App\Forms\User;
use App\Forms\BaseForm;

/**
 * Class LoginForm
 *
 * @package   App\Forms\User
 * @author    Faisal Raza <faisal.raza@gems.techverx.com>
 * @copyright 2020 Techverx.com All rights reserved.
 * @since     Feb 25, 2020
 * @project   reloop
 */
class LoginForm extends BaseForm
{

    public $email;
    public $password;
    /**
     * @inheritDoc
     */
    public function toArray()
    {
        return [
            'email'     => $this->email,
            'password'  => $this->password
        ];
    }

    /**
     * @inheritDoc
     */
    public function rules()
    {
        return [
            'email' => 'required',
            'password' => 'required'
        ];
    }
}

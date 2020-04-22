<?php


namespace App\Forms\User;
use App\Forms\BaseForm;

/**
 * Class PasswordResetForm
 *
 * @package   App\Forms\User
 * @author    Faisal Raza <faisal.raza@gems.techverx.com>
 * @copyright 2020 Techverx.com All rights reserved.
 * @since     Apr 22, 2020
 * @project   reloop
 */
class PasswordResetForm extends BaseForm
{
    public $reset_token;
    public $new_password;
    public $new_password_confirmation;

    public function toArray()
    {
        return [
            'reset_token'                => $this->reset_token,
            'new_password'               => $this->new_password,
            'new_password_confirmation'  => $this->new_password_confirmation
        ];
    }

    public function rules()
    {
        return [
            'reset_token' => 'required',
            'new_password' => 'required|confirmed|min:8',
            'new_password_confirmation' => 'required',
        ];
    }
}

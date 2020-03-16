<?php


namespace App\Forms\User;
use App\Forms\BaseForm;

/**
 * Class ChangePasswordForm
 *
 * @package   App\Forms\User
 * @author    Faisal Raza <faisal.raza@gems.techverx.com>
 * @copyright 2020 Techverx.com All rights reserved.
 * @since     Mar 16, 2020
 * @project   reloop
 */
class ChangePasswordForm extends BaseForm
{
    public $old_password;
    public $new_password;
    public $new_password_confirmation;

    /**
     * @inheritDoc
     */
    public function toArray()
    {
        return [
            'old_password'           => $this->old_password,
            'new_password'           => $this->new_password,
            'new_password_confirmation'  => $this->new_password_confirmation,
        ];
    }

    /**
     * @inheritDoc
     */
    public function rules()
    {
        return [
            'old_password' => 'required',
            'new_password' => 'required|confirmed|min:8',
            'new_password_confirmation' => 'required',
        ];
    }
}

<?php


namespace App\Forms\User;


use App\Forms\BaseForm;

class PasswordResetForm extends BaseForm
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
            'token'  => $this->token
        ];
    }

    /**
     * @inheritDoc
     */
    public function rules()
    {
        return [
            'email' => 'required|email',
            'token' => 'required'
        ];
    }
}

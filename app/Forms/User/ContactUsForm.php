<?php


namespace App\Forms\User;
use App\Forms\BaseForm;

/**
 * Class ContactUsForm
 *
 * @package   App\Forms\User
 * @author    Faisal Raza <faisal.raza@gems.techverx.com>
 * @copyright 2020 Techverx.com All rights reserved.
 * @since     Apr 01, 2020
 * @project   reloop
 */
class ContactUsForm extends BaseForm
{
    public $email;
    public $subject;
    public $message;

    /**
     * @inheritDoc
     */
    public function toArray()
    {
        return [
            'email'   => $this->email,
            'subject' => $this->subject,
            'message' => $this->message
        ];
    }

    /**
     * @inheritDoc
     */
    public function rules()
    {
        return [
            'email'   => 'required|email',
            'subject' => 'required',
            'message' => 'required'
        ];
    }
}

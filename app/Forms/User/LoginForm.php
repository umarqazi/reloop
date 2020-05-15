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
    public $login_type;
    public $status;
    public $reports;
    public $api_token;
    public $user_type;
    public $player_id;

    public function __construct()
    {
        $this->status = 1;
        $this->reports = 1;
        $this->user_type = 1;
        $this->api_token = str_random(50).strtotime('now');
    }
    /**
     * @inheritDoc
     */
    public function toArray()
    {
        return [
            'email'        => $this->email,
            'password'     => $this->password,
            'login_type'   => $this->login_type,
            'player_id'    => $this->player_id
        ];
    }

    /**
     * @inheritDoc
     */
    public function rules()
    {
        return [
            'email' => 'required|email',
            'login_type'   => 'required|between:1,3|integer',
            'password' => 'required_if:login_type,==,1',
        ];
    }
}

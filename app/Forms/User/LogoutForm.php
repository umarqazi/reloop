<?php


namespace App\Forms\User;


use App\Forms\BaseForm;

/**
 * Class LogoutForm
 *
 * @package   App\Forms\User
 * @author    Faisal Raza <faisal.raza@gems.techverx.com>
 * @copyright 2020 Techverx.com All rights reserved.
 * @since     Jun 12, 2020
 * @project   reloop
 */
class LogoutForm extends BaseForm
{

    public $player_id;

    public function toArray()
    {
        return [
            'player_id' => $this->player_id
        ];
    }

    public function rules()
    {
        return [
            'player_id' => 'required'
        ];
    }
}

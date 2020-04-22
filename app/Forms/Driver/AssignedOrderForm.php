<?php


namespace App\Forms\Driver;


use App\Forms\BaseForm;

/**
 * Class AssignedOrderForm
 *
 * @package   App\Forms\Driver
 * @author    Faisal Raza <faisal.raza@gems.techverx.com>
 * @copyright 2020 Techverx.com All rights reserved.
 * @since     Apr 22, 2020
 * @project   reloop
 */
class AssignedOrderForm extends BaseForm
{

    public $date;

    public function toArray()
    {
        return [
            'date' => $this->date
        ];
    }

    public function rules()
    {
        // TODO: Implement rules() method.
    }
}

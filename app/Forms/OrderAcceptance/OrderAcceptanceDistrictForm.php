<?php


namespace App\Forms\OrderAcceptance;


use App\Forms\BaseForm;

/**
 * Class OrderAcceptanceDistrictForm
 *
 * @package   App\Forms\OrderAcceptance
 * @author    Faisal Raza <faisal.raza@gems.techverx.com>
 * @copyright 2020 Techverx.com All rights reserved.
 * @since     Jun 03, 2020
 * @project   reloop
 */
class OrderAcceptanceDistrictForm extends BaseForm
{

    public $district_id;

    public function toArray()
    {
        return [
            'district_id' => $this->district_id
        ];
    }

    public function rules()
    {
        return [
            'district_id' => 'required'
        ];
    }
}

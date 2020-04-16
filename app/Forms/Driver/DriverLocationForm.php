<?php


namespace App\Forms\Driver;
use App\Forms\BaseForm;

/**
 * Class DriverLocationForm
 *
 * @package   App\Forms\Driver
 * @author    Faisal Raza <faisal.raza@gems.techverx.com>
 * @copyright 2020 Techverx.com All rights reserved.
 * @since     Apr 17, 2020
 * @project   reloop
 */
class DriverLocationForm extends BaseForm
{

    public $latitude;
    public $longitude;

    /**
     * Method: toArray
     *
     * @return array
     */
    public function toArray()
    {
        return [
            'latitude'       => $this->latitude,
            'longitude'      => $this->longitude
        ];
    }

    /**
     * Method: rules
     *
     * @return mixed|string[]
     */
    public function rules()
    {
        return [
            'latitude'       => 'required',
            'longitude'      => 'required'
        ];
    }
}

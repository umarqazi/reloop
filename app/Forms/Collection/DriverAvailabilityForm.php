<?php


namespace App\Forms\Collection;


use App\Forms\BaseForm;

/**
 * Class DriverAvailabilityForm
 *
 * @package   App\Forms\Collection
 * @author    Faisal Raza <faisal.raza@gems.techverx.com>
 * @copyright 2020 Techverx.com All rights reserved.
 * @since     Jul 15, 2020
 * @project   reloop
 */
class DriverAvailabilityForm extends BaseForm
{

    public $collection_date;
    public $city_id;
    public $district_id;

    public function toArray()
    {
        return [
            'collection_date' => $this->collection_date,
            'city_id' => $this->city_id,
            'district_id' => $this->district_id,
        ];
    }

    public function rules()
    {
        // TODO: Implement rules() method.
    }
}

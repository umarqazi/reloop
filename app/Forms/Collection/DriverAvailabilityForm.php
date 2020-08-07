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

    public function toArray()
    {
        return [
            'collection_date' => $this->collection_date
        ];
    }

    public function rules()
    {
        return [
            'collection_date' => 'required'
        ];
    }
}

<?php


namespace App\Forms\User;
use App\Forms\BaseForm;

/**
 * Class UpdateAddressForm
 *
 * @package   App\Forms\User
 * @author    Faisal Raza <faisal.raza@gems.techverx.com>
 * @copyright 2020 Techverx.com All rights reserved.
 * @since     Mar 17, 2020
 * @project   reloop
 */
class UpdateAddressForm extends BaseForm
{
    public $id;
    public $city_id;
    public $district_id;
    public $location;
    public $latitude;
    public $longitude;
    public $type;
    public $street;
    public $no_of_bedrooms;
    public $no_of_occupants;
    public $floor;
    public $unit_number;

    /**
     * @inheritDoc
     */
    public function toArray()
    {
        return [
            'id'              =>$this->id,
            'city_id'         =>$this->city_id,
            'district_id'     =>$this->district_id,
            'location'        =>$this->location,
            'latitude'        =>$this->latitude,
            'longitude'       =>$this->longitude,
            'type'            =>$this->type,
            'street'          =>$this->street,
            'no_of_bedrooms'  =>$this->no_of_bedrooms,
            'no_of_occupants' =>$this->no_of_occupants,
            'floor'           =>$this->floor,
            'unit_number'     =>$this->unit_number
        ];
    }

    /**
     * @inheritDoc
     */
    public function rules()
    {
        return [
            'city_id'         =>'required',
            'district_id'     =>'required',
            'location'        =>'required',
            'latitude'        =>'required',
            'longitude'       =>'required',
        ];
    }
}

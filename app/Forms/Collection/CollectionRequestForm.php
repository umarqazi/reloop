<?php


namespace App\Forms\Collection;


use App\Forms\BaseForm;

/**
 * Class CollectionRequestForm
 *
 * @package   App\Forms\Collection
 * @author    Faisal Raza <faisal.raza@gems.techverx.com>
 * @copyright 2020 Techverx.com All rights reserved.
 * @since     Mar 25, 2020
 * @project   reloop
 */
class CollectionRequestForm extends BaseForm
{
    public $first_name;
    public $last_name;
    public $collection_date;
    public $collection_type;
    public $phone_number;
    public $location;
    public $latitude;
    public $longitude;
    public $city_id;
    public $district_id;
    public $street;
    public $material_categories;
    public $questions;
    public $card_number;
    public $exp_month;
    public $cvv;
    public $exp_year;
    public $total;

    /**
     * @inheritDoc
     */
    public function toArray()
    {
        return [
            'collection_date'     => $this->collection_date,
            'collection_type'     => $this->collection_type,
            'first_name'          => $this->first_name,
            'last_name'           => $this->last_name,
            'phone_number'        => $this->phone_number,
            'location'            => $this->location,
            'latitude'            => $this->latitude,
            'longitude'           => $this->longitude,
            'city_id'             => $this->city_id,
            'district_id'         => $this->district_id,
            'street'              => $this->street,
            'material_categories' => $this->material_categories,
            'questions'           => $this->questions,
            'card_number'         => $this->card_number,
            'exp_month'           => $this->exp_month,
            'exp_year'            => $this->exp_year,
            'cvv'                 => $this->cvv,
            'total'               => $this->total
        ];
    }

    /**
     * @inheritDoc
     */
    public function rules()
    {
        return [
            'collection_date'     =>'required|date_format:Y-m-d',
            'first_name'          =>'required',
            'last_name'           =>'required',
            'phone_number'        =>'required',
            'location'            =>'required',
            'latitude'            =>'required',
            'longitude'           =>'required',
            'city_id'             =>'required',
            'district_id'         =>'required',
            'street'              =>'required',
            'material_categories' =>'required',
            'questions'           =>'required'
        ];
    }
}

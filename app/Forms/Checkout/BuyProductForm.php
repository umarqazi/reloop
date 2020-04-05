<?php


namespace App\Forms\Checkout;
use App\Forms\BaseForm;

/**
 * Class BuyProductForm
 *
 * @package   App\Forms\Checkout
 * @author    Faisal Raza <faisal.raza@gems.techverx.com>
 * @copyright 2020 Techverx.com All rights reserved.
 * @since     Mar 11, 2020
 * @project   reloop
 */
class BuyProductForm extends BaseForm
{
    public $card_number;
    public $exp_month;
    public $cvv;
    public $exp_year;
    public $total;
    public $subtotal;
    public $points_discount;
    public $coupon_id;
    public $first_name;
    public $last_name;
    public $email;
    public $phone_number;
    public $location;
    public $latitude;
    public $longitude;
    public $city_id;
    public $district_id;
    public $products;
    public $organization_name;

    /**
     * @inheritDoc
     */
    public function toArray()
    {
        return [
            'card_number'         => $this->card_number,
            'exp_month'           => $this->exp_month,
            'cvv'                 => $this->cvv,
            'exp_year'            => $this->exp_year,
            'subtotal'            => $this->subtotal,
            'points_discount'     => $this->points_discount,
            'coupon_id'           => $this->coupon_id,
            'total'               => $this->total,
            'first_name'          => $this->first_name,
            'last_name'           => $this->last_name,
            'organization_name'   => $this->organization_name,
            'email'               => $this->email,
            'phone_number'        => $this->phone_number,
            'location'            => $this->location,
            'latitude'            => $this->latitude,
            'longitude'           => $this->longitude,
            'city_id'             => $this->city_id,
            'district_id'         => $this->district_id,
            'products'            => $this->products,
        ];
    }

    /**
     * @inheritDoc
     */
    public function rules()
    {
        return [
            'card_number'     => 'required',
            'exp_month'       => 'required',
            'cvv'             => 'required',
            'exp_year'        => 'required',
            'subtotal'        => 'required',
            'total'           => 'required',
            'email'           => 'required',
            'phone_number'    => 'required',
            'location'        => 'required',
            'latitude'        => 'required',
            'longitude'       => 'required',
            'city_id'         => 'required',
            'district_id'     => 'required',
            'products'        => 'required'
        ];
    }
}

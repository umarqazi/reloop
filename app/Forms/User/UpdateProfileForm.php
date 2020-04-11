<?php


namespace App\Forms\User;
use App\Forms\BaseForm;

/**
 * Class UpdateProfileForm
 *
 * @package   App\Forms\User
 * @author    Faisal Raza <faisal.raza@gems.techverx.com>
 * @copyright 2020 Techverx.com All rights reserved.
 * @since     Mar 19, 2020
 * @project   reloop
 */
class UpdateProfileForm extends BaseForm
{
    public $first_name;
    public $last_name;
    public $organization_id;
    public $organization_name;
    public $hh_organization_name;
    public $phone_number;
    public $profile_pic;
    public $no_of_employees;
    public $no_of_branches;
    public $sector_id;

    /**
     * @inheritDoc
     */
    public function toArray()
    {
        return [
            'first_name'            => $this->first_name,
            'last_name'             => $this->last_name,
            'organization_id'       => $this->organization_id,
            'organization_name'     => $this->organization_name,
            'hh_organization_name'  => $this->hh_organization_name,
            'phone_number'          => $this->phone_number,
            'profile_pic'           => $this->profile_pic,
            'no_of_employees'       => $this->no_of_employees,
            'no_of_branches'        => $this->no_of_branches,
            'sector_id'             => $this->sector_id,
        ];
    }

    /**
     * @inheritDoc
     */
    public function rules()
    {
        // TODO: Implement rules() method.
    }
}

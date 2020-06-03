<?php


namespace App\Forms\Organization;


use App\Forms\BaseForm;

/**
 * Class OrganizationVerificationForm
 *
 * @package   App\Forms\Organization
 * @author    Faisal Raza <faisal.raza@gems.techverx.com>
 * @copyright 2020 Techverx.com All rights reserved.
 * @since     Jun 03, 2020
 * @project   reloop
 */
class OrganizationVerificationForm extends BaseForm
{

    public $org_external_id;

    public function toArray()
    {
        return [
            'org_external_id' => $this->org_external_id
        ];
    }

    public function rules()
    {
        return [
            'org_external_id' => 'required'
        ];
    }
}

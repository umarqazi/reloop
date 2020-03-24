<?php


namespace App\Services;


use App\Forms\IForm;
use App\Forms\User\CreateForm;
use App\Organization;
use Illuminate\Validation\ValidationException;

/**
 * Class OrganizationService
 *
 * @package   App\Services
 * @author    Faisal Raza <faisal.raza@gems.techverx.com>
 * @copyright 2020 Techverx.com All rights reserved.
 * @since     Feb 20, 2020
 * @project   reloop
 */
class OrganizationService extends BaseService
{

    private $model;

    /**
     * OrganizationService constructor.
     * @param Organization $model
     */
    public function __construct(Organization $model)
    {
        parent::__construct();
        $this->model = $model;
    }

    /**
     * Method: store
     *
     * @param IForm $form
     *
     * @return Organization|mixed
     */
    public function store(IForm $form)
    {
        /* @var CreateForm $form */
        $form->fails();
        $model = $this->model;
        $form->loadToModel($model);
        $model->name = $form->organization_name;
        $model->save();

        return $model;
    }

    /**
     * @inheritDoc
     */
    public function findById($id)
    {
        return $this->model->find($id);
    }

    /**
     * @inheritDoc
     */
    public function remove($id)
    {

    }

    public function getAll()
    {
        return $this->model->all();
    }

    /**
     * Method: update
     *
     * @param $id
     * @param $data
     *
     * @return void
     */
    public function update($id, $data)
    {
        $organization = $this->findById($id);
        if($organization){

            $organization->name = $data->organization_name ?? $organization->name;
            $organization->no_of_branches = $data->no_of_branches ?? $organization->no_of_branches;
            $organization->no_of_employees = $data->no_of_employees ?? $organization->no_of_employees;
            $organization->sector_id = $data->sector_id ?? $organization->sector_id;
            $organization->update();
        }
    }
}

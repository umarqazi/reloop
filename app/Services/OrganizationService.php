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
        $model->save();

        return $model;
    }

    /**
     * @inheritDoc
     */
    public function findById($id)
    {

    }

    /**
     * @inheritDoc
     */
    public function remove($id)
    {

    }
}

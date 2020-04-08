<?php


namespace App\Services;


use App\Forms\IForm;
use App\MaterialCategory;
use Illuminate\Validation\ValidationException;

/**
 * Class MaterialCategoryService
 *
 * @package   App\Services
 * @author    Faisal Raza <faisal.raza@gems.techverx.com>
 * @copyright 2020 Techverx.com All rights reserved.
 * @since     Mar 24, 2020
 * @project   reloop
 */
class MaterialCategoryService extends BaseService
{
    /**
     * Property: model
     *
     * @var MaterialCategory
     */
    private $model;

    /**
     * MaterialCategoryService constructor.
     * @param MaterialCategory $model
     */
    public function __construct(MaterialCategory $model)
    {
        parent::__construct();
        $this->model = $model;
    }

    /**
     * @inheritDoc
     */
    public function store(IForm $form)
    {
        // TODO: Implement store() method.
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
        // TODO: Implement remove() method.
    }

    /**
     * Method: getAll
     *
     * @return MaterialCategory[]|\Illuminate\Database\Eloquent\Collection
     */
    public function getAll()
    {
        return $this->model->where('status', true)->get();
    }

    /**
     * Method: findMaterialCategoryById
     *
     * @param $data
     *
     * @return mixed
     */
    public function findMaterialCategoryById($data)
    {
        return $this->model->find(array_column($data, 'id'));
    }
}

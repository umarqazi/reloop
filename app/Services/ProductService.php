<?php


namespace App\Services;


use App\Categories;
use App\Forms\IForm;
use Illuminate\Validation\ValidationException;

/**
 * Class ProductService
 *
 * @package   App\Services
 * @author    Faisal Raza <faisal.raza@gems.techverx.com>
 * @copyright 2020 Techverx.com All rights reserved.
 * @since     Feb 27, 2020
 * @project   reloop
 */
class ProductService extends BaseService
{

    private $model;

    /**
     * ProductService constructor.
     * @param Categories $model
     */
    public function __construct(Categories $model)
    {
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
        // TODO: Implement findById() method.
    }

    /**
     * @inheritDoc
     */
    public function remove($id)
    {
        // TODO: Implement remove() method.
    }

    /**
     * Method: categoriesList
     *
     * @return Categories[]|\Illuminate\Database\Eloquent\Collection
     */
    public function categoriesList()
    {
        $model = $this->model->all();
        return $model;
    }
}

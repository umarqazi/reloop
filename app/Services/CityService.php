<?php


namespace App\Services;


use App\City;
use App\Forms\IForm;
use Illuminate\Validation\ValidationException;

/**
 * Class CityService
 *
 * @package   App\Services
 * @author    Faisal Raza <faisal.raza@gems.techverx.com>
 * @copyright 2020 Techverx.com All rights reserved.
 * @since     Mar 06, 2020
 * @project   reloop
 */
class CityService extends BaseService
{

    /**
     * Property: model
     *
     * @var City
     */
    private $model;

    public function __construct(City $model)
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

    public function getAll()
    {
        return $this->model->all();
    }
}

<?php


namespace App\Services;


use App\District;
use App\Forms\IForm;
use Illuminate\Validation\ValidationException;

class DistrictService extends BaseService
{

    /**
     * Property: model
     *
     * @var District
     */
    private $model;

    public function __construct(District $model)
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

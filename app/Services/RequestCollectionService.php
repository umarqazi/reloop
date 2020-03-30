<?php


namespace App\Services;


use App\Forms\IForm;
use App\RequestCollection;
use Illuminate\Validation\ValidationException;

/**
 * Class RequestCollectionService
 *
 * @package   App\Services
 * @author    Faisal Raza <faisal.raza@gems.techverx.com>
 * @copyright 2020 Techverx.com All rights reserved.
 * @since     Mar 25, 2020
 * @project   reloop
 */
class RequestCollectionService extends BaseService
{
    /**
     * Property: model
     *
     * @var RequestCollection
     */
    private $model;

    public function __construct(RequestCollection $model)
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
     * Method: create
     *
     * @param $data
     * @param $requestId
     *
     * @return void
     */
    public function create($data, $requestId)
    {
        $model = $this->model;
        foreach ($data['material_category_details'] as $material_category){

            $model->create([
                'request_id' => $requestId,
                'category_name' => $material_category->name
            ]);
        }
    }
}

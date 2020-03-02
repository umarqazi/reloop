<?php


namespace App\Services;


use App\Address;
use App\Forms\IForm;
use Illuminate\Validation\ValidationException;

/**
 * Class AddressService
 *
 * @package   App\Services
 * @author    Faisal Raza <faisal.raza@gems.techverx.com>
 * @copyright 2020 Techverx.com All rights reserved.
 * @since     Mar 02, 2020
 * @project   reloop
 */
class AddressService extends BaseService
{
    /**
     * Property: model
     *
     * @var Address
     */
    private $model;

    public function __construct(Address $model)
    {
        $this->model = $model;

        parent::__construct();
    }

    /**
     * @inheritDoc
     */
    public function store(IForm $form)
    {
        // TODO: Implement store() mehtod.
    }

    /**
     * Method: storeAddress
     *
     *
     * @param array $data
     *
     * @return mixed
     */
    public function storeAddress(array $data)
    {
        return $this->model->create(
            $data
        );
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
}

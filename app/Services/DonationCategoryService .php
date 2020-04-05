<?php


namespace App\Services;
use App\DonationProductCategory;
use App\Forms\IForm;
use Illuminate\Validation\ValidationException;

/**
 * Class DonationCategoryService
 *
 * @package   App\Services
 * @author    Faisal Raza <faisal.raza@gems.techverx.com>
 * @copyright 2020 Techverx.com All rights reserved.
 * @since     Apr 05, 2020
 * @project   reloop
 */
class DonationCategoryService extends BaseService
{

    /**
     * Property: model
     *
     * @var DonationProductCategory
     */
    private $model;

    /**
     * DonationCategoryService constructor.
     * @param DonationProductCategory $model
     */
    public function __construct(DonationProductCategory $model)
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
     * Method: getAll
     *
     * @return DonationProductCategory[]|\Illuminate\Database\Eloquent\Collection
     */
    public function getAll()
    {
        return $this->model->all();
    }
}

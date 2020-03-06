<?php


namespace App\Services;


use App\Forms\IForm;
use App\Sector;
use Illuminate\Validation\ValidationException;

/**
 * Class SectorService
 *
 * @package   App\Services
 * @author    Faisal Raza <faisal.raza@gems.techverx.com>
 * @copyright 2020 Techverx.com All rights reserved.
 * @since     Mar 06, 2020
 * @project   reloop
 */
class SectorService extends BaseService
{

    /**
     * Property: sector
     *
     * @var Sector
     */
    private $model;

    public function __construct(Sector $model)
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

    public function getAll()
    {
        return $this->model->all();
    }
}

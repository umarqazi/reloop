<?php

namespace App\Services;
use App\Forms\IForm;
use App\Setting;
use Illuminate\Validation\ValidationException;

/**
 * Class SettingService
 *
 * @package   App\Services
 * @author    Faisal Raza <faisal.raza@gems.techverx.com>
 * @copyright 2020 Techverx.com All rights reserved.
 * @since     Apr 21, 2020
 * @project   reloop
 */
class SettingService extends BaseService
{

    /**
     * Property: model
     *
     * @var Setting
     */
    private $model;

    public function __construct(Setting $model)
    {
        parent::__construct();
        $this->model = $model;
    }

    public function store(IForm $form)
    {
        // TODO: Implement store() method.
    }

    public function findById($id)
    {
        // TODO: Implement findById() method.
    }

    public function remove($id)
    {
        // TODO: Implement remove() method.
    }

    /**
     * Method: findByKey
     *
     * @param $key
     *
     * @return mixed
     */
    public function findByKey($key)
    {
        return $this->model->where('keys', $key)->first();
    }
}

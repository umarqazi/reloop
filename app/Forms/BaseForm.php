<?php
namespace App\Forms;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;

/**
 * Class BaseForm
 *
 * @package   App\Forms
 * @author    Faisal Raza <faisal.raza@gems.techverx.com>
 * @copyright 2020 Techverx.com All rights reserved.
 * @since     Feb 20, 2020
 * @project   reloop
 */
abstract class BaseForm implements IForm
{
    /**
     * @return \Illuminate\Support\MessageBag|mixed
     */
    public function errors()
    {
        return $this->getValidator()->errors();
    }

    /**
     * @return bool
     */
    public function passes()
    {
        return $this->getValidator()->passes();
    }

    /**
     * @return bool
     */
    public function fails()
    {
        return $this->getValidator()->fails();
    }

    /**
     * @return array|mixed
     */
    public function errorMessages()
    {
        return [];
    }

    /**
     * Load Form properties from given array
     *
     * @param array $params Array containing form data
     *
     * @return void
     */
    public function loadFromArray($params)
    {
        foreach ($params as $key => $value) {

            if (property_exists($this, $key)) {

                $this->$key = $value;
            }
        }
    }

    /**
     * @param Model $model
     */
    public function loadToModel($model)
    {
        $keys = $model->getFillable();
        foreach($keys as $key){
            if(property_exists($this, $key) || !empty($this->$key)){
                $model->$key = $this->$key;
            }
        }
    }

    /**
     * @return \Illuminate\Contracts\Validation\Validator
     */
    private function getValidator()
    {
        $validator = Validator::make($this->toArray(), $this->rules(), $this->errorMessages());
        return $validator;
    }

    /**
     * @return mixed|void
     */
    public function validate()
    {
        return $this->getValidator()->validate();
    }

}

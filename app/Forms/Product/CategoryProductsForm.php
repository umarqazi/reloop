<?php


namespace App\Forms\Product;


use App\Forms\BaseForm;

/**
 * Class CategoryProductsForm
 *
 * @package   App\Forms\Product
 * @author    Faisal Raza <faisal.raza@gems.techverx.com>
 * @copyright 2020 Techverx.com All rights reserved.
 * @since     Feb 28, 2020
 * @project   reloop
 */
class CategoryProductsForm extends BaseForm
{

    public $category_id;
    /**
     * @inheritDoc
     */
    public function toArray()
    {
        return [
            'category_id' => $this->category_id,
        ];
    }

    /**
     * @inheritDoc
     */
    public function rules()
    {
        return [
            'category_id' => 'required',
        ];
    }
}

<?php


namespace App\Repositories\Admin;


use App\MaterialCategory;

class MaterialCategoryRepo extends BaseRepo
{
    private $getModel;

    /**
     * MaterialCategoryRepo constructor.
     */
    public function __construct()
    {
        $getModel = $this->getModel(MaterialCategory::class);
        $this->getModel = new $getModel;
    }
}

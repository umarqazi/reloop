<?php


namespace App\Repositories\Admin;


use App\Category;
use App\Product;
use App\Repositories\Admin\BaseRepo;

class CategoryRepo extends BaseRepo
{
    /**
     * UserRepo constructor.
     */
    public function __construct()
    {
        $this->getModel(Category::class);
    }

    /**
     * get  categories
     */
    public function getCategory($type){
        $Categories =  $this->getModel(Category::class)->where('type', $type)->where('status', 1)->get();
        return $Categories;
    }


}

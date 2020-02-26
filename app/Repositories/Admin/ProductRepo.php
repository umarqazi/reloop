<?php


namespace App\Repositories\Admin;


use App\Product;
use App\Repositories\BaseRepo;

class ProductRepo extends BaseRepo
{
    /**
     * UserRepo constructor.
     */
    public function __construct()
    {
        $this->getModel(Product::class);
    }

}

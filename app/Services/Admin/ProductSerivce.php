<?php


namespace App\Services\Admin;


use App\Repositories\Admin\ProductRepo;
use App\Services\BaseService;
use Illuminate\Http\Request;

class ProductSerivce extends BaseService
{

    public function __construct()
    {
        $this->getRepo(ProductRepo::class);
    }

}

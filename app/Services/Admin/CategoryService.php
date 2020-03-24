<?php


namespace App\Services\Admin;


use App\Repositories\Admin\CategoryRepo;
use App\Services\Admin\BaseService;
use Illuminate\Http\Request;

class CategoryService extends BaseService
{

    private $categoryRepo;

    /**
     * CategoryService constructor.
     */

    public function __construct()
    {
        $categoryRepo =  $this->getRepo(CategoryRepo::class);
        $this->categoryRepo = new $categoryRepo;
    }

    public function getCategory(int $type){
        return $this->categoryRepo->getCategory($type);
    }

}

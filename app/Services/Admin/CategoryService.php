<?php


namespace App\Services\Admin;


use App\Repositories\Admin\CategoryRepo;
use App\Services\Admin\BaseService;
use App\Services\ICategoryType;
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

    public function upgrade($id, $request)
    {
        $data = $request->except('_token', '_method', 'email');

        if($data['type'] == ICategoryType::PRODUCT){
            $data['service_type'] = null;
        }
        return parent::update($id, $data);
    }

}

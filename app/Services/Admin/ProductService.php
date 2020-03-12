<?php


namespace App\Services\Admin;


use App\Repositories\Admin\ProductRepo;
use App\Services\Admin\BaseService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class ProductService extends BaseService
{

    private $productRepo;

    /**
     * ProductService constructor.
     */

    public function __construct()
    {
        $productRepo =  $this->getRepo(ProductRepo::class);
        $this->productRepo = new $productRepo;
    }


    /**
     * @param array $data
     * @return bool
     */
    public function insert($request)
    {
        //check that avatar exists or not
        $data = $request->except('_token');

        return parent::create($data);
    }

    /**
     * @param array $data
     * @param  int $id
     * @return bool
     */
    public function upgrade($id, $request)
    {
        $data = $request->except('_token', '_method', 'email');

        return parent::update($id, $data);
    }

    /**
     * @param int $id
     * @return mixed
     */
    public function destroy(int $id)
    {
        return parent::destroy($id);
    }


}

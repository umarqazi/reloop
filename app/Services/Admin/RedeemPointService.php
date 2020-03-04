<?php


namespace App\Services\Admin;


use App\Repositories\Admin\ProductRepo;
use App\Repositories\Admin\RedeemPointRepo;
use App\Services\Admin\BaseService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use App\Services\StripeService;

class RedeemPointService extends BaseService
{

    private $redeemPointRepo;

    /**
     * RedeemPointService constructor.
     */

    public function __construct()
    {
        $redeemPointRepo =  $this->getRepo(RedeemPointRepo::class);
        $this->productRepo = new $redeemPointRepo;
    }


    /**
     * @param array $data
     * @return bool
     */
    public function insert($request)
    {
        //excluding token
        $data = $request->except('_token');

        return  parent::create($data);
    }

    /**
     * @param array $data
     * @param  int $id
     * @return bool
     */
    public function upgrade($id, $request)
    {
        $data = $request->except('_token');

        return parent::update($id, $data);
    }


}

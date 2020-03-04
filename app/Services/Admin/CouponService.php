<?php


namespace App\Services\Admin;


use App\Repositories\Admin\CouponRepo;
use App\Services\Admin\BaseService;

class CouponService extends BaseService
{

    private $couponRepo;

    /**
     * CouponService constructor.
     */

    public function __construct()
    {
        $couponRepo =  $this->getRepo(CouponRepo::class);
        $this->couponRepo = new $couponRepo;
    }


    /**
     * @param array $data
     * @return bool
     */
    public function insert($request)
    {
        //exclude token
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

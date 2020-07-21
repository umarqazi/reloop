<?php


namespace App\Services\Admin;


use App\Repositories\Admin\CouponRepo;
use App\Services\Admin\BaseService;
use App\Services\IApplyForCategory;
use App\Services\IApplyForUser;

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
        if ($data['apply_for_category'] == IApplyForCategory::APPLY_ON_CATEGORY_TYPE){
            $data['list_category_id'] = null;
        }
        if ($data['apply_for_user'] == IApplyForUser::APPLY_ON_USER_TYPE){
            $data['list_user_id'] = null;
        }
        return parent::update($id, $data);
    }


}

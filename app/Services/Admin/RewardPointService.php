<?php


namespace App\Services\Admin;


use App\Repositories\Admin\RewardPointRepo;
use App\Services\Admin\BaseService;

class RewardPointService extends BaseService
{

    private $rewardPointRepo;

    /**
     * RewardPointService constructor.
     */

    public function __construct()
    {
        $rewardPointRepo =  $this->getRepo(RewardPointRepo::class);
        $this->rewardPointRepo = new $rewardPointRepo;
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

<?php


namespace App\Services\Admin;


use App\Repositories\Admin\SubscriptionRepo;
use App\Services\BaseService;
use Illuminate\Http\Request;

class SubscriptionSerivce extends BaseService
{

    public function __construct()
    {
        $this->getRepo(SubscriptionRepo::class);
    }

}

<?php


namespace App\Repositories\Admin;


use App\Order;
use App\Repositories\Admin\BaseRepo;
use App\Repositories\Admin\UserRepo;
use App\Request;
use App\RequestCollection;
use App\Services\IUserType;
use Illuminate\Support\Facades\Auth;
use PHPUnit\Framework\Constraint\Count;

class RequestCollectionRepo extends BaseRepo
{
    private $order ;
    /**
     * RequestCollection constructor.
     */
    public function __construct()
    {
        $this->getModel(RequestCollection::class);
    }

}

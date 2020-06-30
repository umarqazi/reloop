<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\ChartService;
use App\Services\DashboardService;
use App\Services\DonationService;
use App\Services\RequestCollectionService;
use Illuminate\Support\Facades\App;
use App\Services\Admin\CollectionRequestService;
use App\Services\Admin\MaterialCategoryService;
use App\Services\Admin\OrderService;
use App\Services\Admin\OrganizationService;
use App\Services\Admin\ProductService;
use App\Services\Admin\UserService;
use App\Services\IUserType;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PHPUnit\Framework\Constraint\Count;

class HomeController extends Controller
{
    private $organizationService ;
    private $userService ;
    private $materialCategoryService ;
    private $productService ;
    private $collectionRequestService ;
    private $orderService ;
    private $donationService;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(OrganizationService $organizationService,
                                UserService $userService,
                                MaterialCategoryService $materialCategoryService,
                                ProductService $productService,
                                CollectionRequestService $collectionRequestService,
                                DonationService $donationService,
                                OrderService $orderService
    ){
        $this->middleware('auth');
        $this->organizationService       = $organizationService;
        $this->userService               = $userService;
        $this->materialCategoryService   = $materialCategoryService;
        $this->productService            = $productService;
        $this->collectionRequestService  = $collectionRequestService;
        $this->orderService              = $orderService;
        $this->donationService           = $donationService;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $organizations      = count($this->organizationService->all()) ;
        $users              = count($this->userService->getSelected(IUserType::HOUSE_HOLD)) ;
        $activeUsers        = App::make(\App\Services\UserService::class)->getActiveUsers();
        $allUsers           = $this->userService->getSelected(IUserType::HOUSE_HOLD)->pluck('email', 'id')->toArray();
        $allOrganizations   = $this->userService->getSelected(IUserType::ORGANIZATION)->pluck('email', 'id')->toArray();
        $allDrivers         = $this->userService->getSelected(IUserType::DRIVER)->pluck('email', 'id')->toArray();
        $allSupervisors     = $this->userService->getSelected(IUserType::SUPERVISOR)->pluck('email', 'id')->toArray();
        $materialCategories = count($this->materialCategoryService->all()) ;
        $products           = count($this->productService->all()) ;

        if (Auth::user()->hasRole('admin')){

            $collectionRequest = count($this->collectionRequestService->all());
            $orders = count($this->orderService->all());
            $dashboard = App::make(DashboardService::class)->dashboard();
            $totalRecycledKg = App::make(RequestCollectionService::class)->calculateWeight();
            $totalAwardedPoints = $this->collectionRequestService->totalAwardedPoints();
            $redeemedReloopPoints = $this->orderService->redeemedReloopPoints();
            $redeemedReloopDonations = $this->donationService->redeemedReloopDonations();
            $totalRedeemedPoints = $redeemedReloopDonations + $redeemedReloopPoints;
        } else {

            $addresses = Auth::user()->addresses;
            $collectionRequest = $this->collectionRequestService->getOrdersForSupervisor($addresses);
            $orders = $this->orderService->getOrdersForSupervisor($addresses);
            $totalRecycledKg  = array_sum(App::make(RequestCollectionService::class)->calculateSupervisorWeight($addresses));
            $dashboard = App::make(DashboardService::class)->supervisorStats(auth()->user()->id);
            $totalAwardedPoints = $this->collectionRequestService->totalAwardedPoints($addresses);
            $redeemedReloopPoints = $this->orderService->redeemedReloopPoints($addresses);
            $redeemedReloopDonations = $this->donationService->redeemedReloopDonations($addresses);
            $totalRedeemedPoints = $redeemedReloopDonations + $redeemedReloopPoints;
        }
        return view('index',compact(
            'organizations','users','materialCategories','products','collectionRequest','orders','dashboard',
            'allSupervisors', 'allDrivers', 'allOrganizations', 'allUsers', 'totalRecycledKg', 'activeUsers', 'totalAwardedPoints',
            'totalRedeemedPoints'
        ));
    }
}

<?php

namespace App\Http\Controllers\Supervisor;

use App\Repositories\Admin\CityRepo;
use App\Repositories\Admin\DistrictRepo;
use App\Repositories\Admin\UserRepo;
use App\Services\IUserType;
use App\Services\Supervisor\OrderService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;

class OrderController extends Controller
{

    private $orderService ;
    private $cityRepo ;
    private $districtRepo;
    private $userRepo;

    /**
     * OrderController constructor.
     */
    public function __construct(OrderService $orderService,CityRepo $cityRepo, DistrictRepo $districtRepo,UserRepo $userRepo) {
        $this->orderService   =  $orderService;
        $this->cityRepo       =  $cityRepo;
        $this->districtRepo   =  $districtRepo;
        $this->userRepo       =  $userRepo;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $city_id = Auth::user()->addresses[0]->city_id ;
        $city = $this->cityRepo->findById($city_id)->name ;
        $didtrict_id = Auth::user()->addresses[0]->district_id ;
        $district = $this->districtRepo->findById($didtrict_id)->name ;
        $orders = $this->orderService->getOrders($city,$district);
        return view('supervisor.orders.index', compact('orders'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $order = $this->orderService->findById($id);
        if($order->driver_id != null){
           $drivers = $this->availableDrivers($order->delivery_date, $id)->pluck('first_name', 'id')->toArray();
        }
        else{
           $drivers = $this->userRepo->getSelected(IUserType::DRIVER)->pluck('first_name', 'id')->toArray();
        }
        return  view('supervisor.orders.view', compact('order','drivers'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function assignOrder(Request $request,$id){
           $order = $this->orderService->upgrade($request,$id);
           if($order){
               return redirect()->back()->with('success',Config::get('constants.ORDER_ASSIGNED'));
           }
           else {
               return redirect()->back()->with('error',Config::get('ORDER_ASSIGNMENT_FAIL'));
           }
    }

    /**
     * @param $date
     * @param $order_id
     * @return mixed
     */
    public function availableDrivers($date,$order_id){
          $availableDrivers = $this->orderService->availableDrivers($date,$order_id);
          return $availableDrivers;
    }
}

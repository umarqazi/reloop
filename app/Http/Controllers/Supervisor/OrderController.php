<?php

namespace App\Http\Controllers\Supervisor;

use App\Services\Admin\CityService;
use App\Services\Admin\DistrictService;
use App\Services\Admin\UserService;
use App\Services\IUserType;
use App\Services\Supervisor\OrderService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;

class OrderController extends Controller
{

    private $orderService ;
    private $cityService ;
    private $districtService;
    private $userService;

    /**
     * OrderController constructor.
     */
    public function __construct(OrderService $orderService,CityService $cityService, DistrictService $districtService,UserService $userService) {
        $this->orderService      =  $orderService;
        $this->cityService       =  $cityService;
        $this->districtService   =  $districtService;
        $this->userService       =  $userService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //get city_id and district_id of current supervisor
        $city_id = Auth::user()->addresses->first()->city_id ;
        $district_id = Auth::user()->addresses->first()->district_id ;

        //get name of city and district of current supervisor
        $city = $this->cityService->findById($city_id)->name ;
        $district = $this->districtService->findById($district_id)->name ;

        //get orders of supervisor's city and district
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
           $drivers = $this->availableDrivers($order->delivery_date, $id);
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
          $availableDrivers = $this->orderService->availableDrivers($date,$order_id)->pluck('first_name', 'id')->toArray();
          return $availableDrivers;
    }
}

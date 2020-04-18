<?php

namespace App\Http\Controllers\Admin;

use App\Services\Admin\OrderService;
use App\Services\IOrderStaus;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;

class OrderController extends Controller
{

    private $orderService ;

    /**
     * OrderController constructor.
     */
    public function __construct(OrderService $orderService) {
        $this->orderService   =  $orderService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $orders = $this->orderService->all();
        return view('orders.index', compact('orders'));
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
            return  view('orders.view', compact('order','drivers'));
        }

        return  view('orders.view', compact('order'));

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
     * @param $date
     * @param $order_id
     * @return mixed
     */
    public function availableDrivers($date,$order_id){
        $availableDrivers = $this->orderService->availableDrivers($date,$order_id)->pluck('first_name', 'id')->toArray();
        return $availableDrivers;
    }

    /**
     * export list
     */
    public function export(){
        Excel::create('orders', function($excel) {
            $excel->sheet('orders', function($sheet) {
                $orders = $this->orderService->all();

                foreach($orders as $order){
                    $print[] = array( 'Id'                  => $order->id,
                                      'Order Number'        => $order->order_number,
                                      'Email'               => $order->email,
                                      'Order Status'        => $order->status == IOrderStaus::ORDER_CONFIRMED ?
                                                               'Order Confirmed'  : ($order->status == IOrderStaus::DRIVER_ASSIGNED ?
                                                               'Driver Assigned'  : ($order->status == IOrderStaus::DRIVER_DISPATCHED)?
                                                               'Order Dispatched' : 'Order Completed' ) ,
                                      'Total'               => $order->total,
                    ) ;
                }

                $sheet->fromArray($print);

            });

        })->export('csv');
    }
}

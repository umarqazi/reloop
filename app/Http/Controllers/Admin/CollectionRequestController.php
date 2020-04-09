<?php

namespace App\Http\Controllers\Admin;

use App\Services\Admin\CollectionRequestService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CollectionRequestController extends Controller
{

    private $collectionRequestService ;

    /**
     * CollectionRequestController constructor.
     */
    public function __construct(CollectionRequestService $collectionRequestService) {
        $this->collectionRequestService   =  $collectionRequestService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $requests = $this->collectionRequestService->all();
        return view('requests.index', compact('requests'));
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
        $request = $this->collectionRequestService->findById($id);

        /*if($order->driver_id != null){
            $drivers = $this->availableDrivers($order->delivery_date, $id);
        }*/

        return  view('requests.view', compact('request',));
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
}

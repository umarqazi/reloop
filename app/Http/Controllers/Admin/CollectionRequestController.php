<?php

namespace App\Http\Controllers\Admin;

use App\Services\Admin\CollectionRequestService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Config;

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

        $drivers = $this->availableDrivers($request->collection_date, $id);
        return  view('requests.view', compact('request','drivers'));
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
        $order = $this->collectionRequestService->upgrade($request,$id);
        if($order){
            return redirect()->back()->with('success',Config::get('constants.COLLECTION_REQUEST_ASSIGNED'));
        }
        else {
            return redirect()->back()->with('error',Config::get('constants.COLLECTION_REQUEST_ASSIGNMENT_FAIL'));
        }
    }

    /**
     * @param $date
     * @param $order_id
     * @return mixed
     */
    public function availableDrivers($date,$order_id){
        $availableDrivers = $this->collectionRequestService->availableDrivers($date,$order_id)->pluck('first_name', 'id')->toArray();
        return $availableDrivers;
    }

    public function confirmRequest($id){

       $confirm = $this->collectionRequestService->confirmRequest($id);

       if($confirm){
           return redirect()->back()->with('success',Config::get('constants.CONFIRM_REQUEST_ASSIGNED'));
       }
       else{
           return redirect()->back()->with('error',Config::get('constants.CONFIRM_REQUEST_ASSIGNMENT_FAIL'));
       }

    }
}

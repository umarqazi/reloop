<?php

namespace App\Http\Controllers\Admin;

use App\Services\Admin\CollectionRequestService;
use App\Services\FeedbackService;
use App\Services\IOrderStaus;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Config;
use Maatwebsite\Excel\Facades\Excel;

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
        $requests->load('city', 'district');
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
        $feedback = App::make(FeedbackService::class)->findByIdAndType($id, \App\Request::class);

        $drivers = $this->availableDrivers($request->collection_date, $id);
        return  view('requests.view', compact('request','drivers', 'feedback'));
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

    /**
     * export list
     */
    public function export(){
        Excel::create('collectionRequests', function($excel) {
            $excel->sheet('collectionRequests', function($sheet) {
                $requests = $this->collectionRequestService->all();
                if(!$requests->isEmpty()) {

                    foreach ($requests as $request) {
                        $print[] = array('Id' => $request->id,
                            'Request Number' => $request->request_number,
                            'Name' => ($request->organization_name) ? $request->organization_name : $request->first_name . ' ' . $request->last_name,
                            'Email' => $request->user->email,
                            'Request Status' => $request->status == IOrderStaus::ORDER_CONFIRMED ?
                                'Request Confirmed' : ($request->status == IOrderStaus::DRIVER_ASSIGNED ?
                                    'Driver Assigned' : ($request->status == IOrderStaus::DRIVER_DISPATCHED) ?
                                        'Request Dispatched' : 'Request Completed'),
                            'Request City' => $request->city->name,
                            'Request District' => $request->district->name,
                            'Location' => $request->location,
                            'Collection Date' => $request->collection_date,
                            'Driver' => $request->driver_id == null ? 'None' : $request->driver->first_name . ' ' . $request->driver->last_name,
                        );
                    }
                    $sheet->fromArray($print);
                }
            });

        })->export('csv');
    }
}

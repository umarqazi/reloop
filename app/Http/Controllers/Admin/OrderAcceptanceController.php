<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\OrderAcceptance\CreateRequest;
use App\Http\Requests\OrderAcceptance\UpdateRequest;
use App\Services\Admin\DistrictService;
use App\Services\Admin\SettingService;
use App\Services\OrderAcceptanceService;
use Illuminate\Support\Facades\Config;
use Maatwebsite\Excel\Facades\Excel;

class OrderAcceptanceController extends Controller
{

    private $orderAcceptanceService ;
    private $districtService ;

    /**
     * OrderAcceptanceController constructor.
     */
    public function __construct(OrderAcceptanceService $orderAcceptanceService,DistrictService $districtService) {
        $this->orderAcceptanceService   =  $orderAcceptanceService;
        $this->districtService          = $districtService;
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $orderTimings = $this->orderAcceptanceService->all() ?? null;
        return view('OrderAcceptance.index', compact('orderTimings'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $districts  = $this->districtService->all()->pluck('name', 'id')->toArray();
        return view('OrderAcceptance.create',compact('districts'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateRequest $request)
    {
        $data = $request->except('_token') ;

        $orderAcceptance = $this->orderAcceptanceService->create($data);

        if ($orderAcceptance) {
            return redirect()->back()->with('success', Config::get('constants.ORDER_ACCEPTANCE_CREATION_SUCCESS'));
        } else {
            return redirect()->back()->with('error', Config::get('constants.ORDER_ACCEPTANCE_CREATION_ERROR'));
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $orderAcceptance = $this->orderAcceptanceService->findById($id);
        $districts       = $this->districtService->all()->pluck('name', 'id')->toArray();

        if ($orderAcceptance) {
            return view('OrderAcceptance.edit', compact('orderAcceptance','districts'));
        } else {
            return view('OrderAcceptance.edit')->with('error', Config::get('constants.ERROR'));
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRequest $request, $id)
    {
        $data = $request->except('_token', '_method');

        $order = $this->orderAcceptanceService->update($id,$data);
            if ($order) {
                return redirect()->back()->with('success', Config::get('constants.ORDER_ACCEPTANCE_UPDATE_SUCCESS'));
            } else {
                return redirect()->back()->with('error', Config::get('constants.ORDER_ACCEPTANCE_UPDATE_ERROR'));
            }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $order = $this->orderAcceptanceService->destroy($id);
        if($order){
            return redirect()->route('order-acceptances.index')->with('success',Config::get('constants.ORDER_ACCEPTANCE_DELETE_SUCCESS'));
        }
        else {
            return redirect()->route('order-acceptances.index')->with('error',Config::get('constants.ORDER_ACCEPTANCE_DELETE_ERROR'));
        }

    }

    /**
     * export list
     */
    public function export(){
        Excel::create('orderAcceptances', function($excel) {
            $excel->sheet('orderAcceptances', function($sheet) {
                $orderTimings = $this->orderAcceptanceService->all();

                foreach($orderTimings as $orderTime){
                    $print[] = array( 'Id'         => $orderTime->id,
                                      'To(Day)'    => $orderTime->to,
                                      'From(From)' => $orderTime->from,
                                      'District'   => $orderTime->district->name
                    ) ;
                }

                $sheet->fromArray($print);

            });

        })->export('csv');
    }
}

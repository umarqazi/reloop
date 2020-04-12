<?php

namespace App\Http\Controllers\Supervisor;

use App\Services\Admin\CityService;
use App\Services\Admin\CollectionRequestService;
use App\Services\Admin\DistrictService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;

class CollectionRequestController extends Controller
{

    private $collectionRequestService ;
    private $cityService ;
    private $districtService ;

    /**
     * CollectionRequestController constructor.
     */
    public function __construct(CollectionRequestService $collectionRequestService, CityService $cityService, DistrictService $districtService) {
        $this->collectionRequestService   =  $collectionRequestService;
        $this->cityService = $cityService;
        $this->districtService = $districtService;
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
        $requests = $this->collectionRequestService->getOrders($city,$district);

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

}

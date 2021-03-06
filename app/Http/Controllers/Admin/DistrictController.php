<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\District\CreateRequest;
use App\Http\Requests\District\UpdateRequest;
use App\Repositories\Admin\DistrictRepo;
use App\Services\Admin\CityService;
use App\Services\Admin\DistrictService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;

class DistrictController extends Controller
{
    private $districtService ;
    private $cityService ;

    /**
     * DistrictController constructor.
     */
    public function __construct(DistrictService $districtService, CityService $cityService) {
        $this->districtService   =  $districtService;
        $this->cityService       =  $cityService;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->districtService->all()->pluck('name', 'id')->toArray();
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
    public function store(CreateRequest $request)
    {
        $data = $request->except('_token') ;
        $data['order_acceptance_days'] = implode(',',$data['order_acceptance_days']);
        $district = $this->districtService->create($data);

        if ($district) {
            return redirect()->back()->with('success', Config::get('constants.DISTRICT_CREATION_SUCCESS'));
        } else {
            return redirect()->back()->with('error', Config::get('constants.DISTRICT_CREATION_ERROR'));
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
        $district = $this->districtService->findById($id);
        $selected_days = explode(',',$district->order_acceptance_days) ;
        $days = Config::get('global.Day');
        if ($district) {
            return view('districts.edit', compact('district','days','selected_days'));
        } else {
            return view('districts.edit')->with('error', Config::get('constants.ERROR'));
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
        $data = $request->except('_token','_method') ;
        $data['order_acceptance_days'] = implode(',',$data['order_acceptance_days']);
        $district = $this->districtService->update($id,$data);
        if ($district) {
            return redirect()->back()->with('success', Config::get('constants.DISTRICT  _UPDATE_SUCCESS'));
        } else {
            return redirect()->back()->with('error', Config::get('constants.DISTRICT_UPDATE_ERROR'));
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
        $district = $this->districtService->destroy($id);
        if($district){
            return redirect()->back()->with('success',Config::get('constants.DISTRICT_DELETE_SUCCESS'));
        }
        else {
            return redirect()->back()->with('error',Config::get('constants.DISTRICT_DELETE_ERROR'));
        }
    }

        /**
         * @param $city_id
         * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
         */
    public function districtCreate($city_id){
        $city = $this->cityService->findById(($city_id));
        $days = Config::get('global.Day');
        return view('districts.create',compact('city','days'));
    }

}

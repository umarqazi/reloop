<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\City\CreateRequest;
use App\Http\Requests\City\UpdateRequest;
use App\Services\Admin\CityService;
use Illuminate\Support\Facades\Config;

class CityController extends Controller
{
    private $cityService ;

    /**
     * CityController constructor.
     */
    public function __construct(CityService $cityService) {
        $this->cityService   =  $cityService;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->cityService->all()->pluck('name', 'id')->toArray();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('cities.create');
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
        $city = $this->cityService->create($data);

        if ($city) {
            return redirect()->back()->with('success', Config::get('constants.CITY_CREATION_SUCCESS'));
        } else {
            return redirect()->back()->with('error', Config::get('constants.CITY_CREATION_ERROR'));
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
        $city = $this->cityService->findById($id);
        if ($city) {
            return view('cities.edit', compact('city'));
        } else {
            return view('cities.edit')->with('error', Config::get('constants.ERROR'));
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
        $city = $this->cityService->update($id,$data);
        if ($city) {
            return redirect()->back()->with('success', Config::get('constants.CITY_UPDATE_SUCCESS'));
        } else {
            return redirect()->back()->with('error', Config::get('constants.CITY_UPDATE_ERROR'));
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
        $city = $this->cityService->destroy($id);
        if($city){
            return redirect()->back()->with('success',Config::get('constants.CITY_DELETE_SUCCESS'));
        }
        else {
            return redirect()->back()->with('error',Config::get('constants.CITY_DELETE_ERROR'));
        }
    }

        /**
         * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
         */
    public function getCities(){

        $cities = $this->cityService->all();
        return view('cities.index', compact('cities'));

    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\RequestCollections\UpdateRequest;
use App\Services\Admin\RequestCollectionService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Config;

class RequestCollectionController extends Controller
{

    private $requestCollectionService ;

    /**
     * RequestCollectionController constructor.
     */
    public function __construct(RequestCollectionService $requestCollectionService) {
        $this->requestCollectionService   =  $requestCollectionService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
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
        $requestCollection = $this->requestCollectionService->findById($id);
        if ($requestCollection) {
            return view('requestCollections.edit', compact('requestCollection'));
        } else {
            return view('questions.edit')->with('error', Config::get('constants.ERROR'));
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
        $weight = $this->requestCollectionService->update($id,$data);
        if ($weight) {
            return redirect()->back()->with('success', Config::get('constants.WEIGHT_UPDATE_SUCCESS'));
        } else {
            return redirect()->back()->with('error', Config::get('constants.WEIGHT_UPDATE_ERROR'));
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
        //
    }
}

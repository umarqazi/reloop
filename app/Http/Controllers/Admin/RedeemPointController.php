<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\RedeemPoint\CreateRequest;
use App\Http\Requests\RedeemPoint\UpdateRequest;
use App\Services\Admin\RedeemPointService;


class RedeemPointController extends Controller
{

    private $redeemPointService ;

    /**
     * ProductController constructor.
     */
    public function __construct(RedeemPointService $redeemPointService) {
        $this->redeemPointService     =  $redeemPointService;
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $redeemPoints = $this->redeemPointService->all() ?? null;
        return view('redeemPoints.index', compact('redeemPoints'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('redeemPoints.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateRequest $request)
    {
        if (!empty($request)) {
            $redeemPoint = $this->redeemPointService->insert($request);
            if ($redeemPoint) {
                return redirect()->back()->with('success', 'Redeem Point Created Successfully');
            } else {
                return redirect()->back()->with('error', 'Error While Creating Redeem Point');
            }
        } else {
            return redirect()->back()->with('error', 'Error While Creating Redeem Point');
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
        $redeemPoint = $this->redeemPointService->findById($id);
        if ($redeemPoint) {
            return view('redeemPoints.edit', compact('redeemPoint'));
        } else {
            return view('redeemPoints.edit')->with('error', 'No Information Founded !');
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
        if (!empty($request)) {
            $redeemPoint = $this->redeemPointService->upgrade($id, $request);
            if ($redeemPoint) {
                return redirect()->back()->with('success', 'Redeem point Update Successfully');
            } else {
                return redirect()->back()->with('error', 'Error While Updating Redeem point');
            }
        } else {
            return redirect()->back()->with('error', 'Error While Updating Redeem point');
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
        $redeemPoint = $this->redeemPointService->destroy($id);
        if($redeemPoint){
            return redirect()->route('redeem-point.index')->with('success','Redeem Point Deleted Successfully');
        }
        else {
            return redirect()->route('redeem-point.index')->with('error','Something went wrong');
        }

    }
}

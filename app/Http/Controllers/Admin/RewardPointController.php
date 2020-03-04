<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\RewardPoint\CreateRequest;
use App\Http\Requests\RewardPoint\UpdateRequest;
use App\Services\Admin\RewardPointService;


class RewardPointController extends Controller
{

    private $rewardPointService ;

    /**
     * RewardPointController constructor.
     */
    public function __construct(RewardPointService $rewardPointService) {
        $this->rewardPointService     =  $rewardPointService;
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $rewardPoints = $this->rewardPointService->all() ?? null;
        return view('rewardPoints.index', compact('rewardPoints'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('rewardPoints.create');
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
            $rewardPoint = $this->rewardPointService->insert($request);
            if ($rewardPoint) {
                return redirect()->back()->with('success', 'Reward Point Created Successfully');
            } else {
                return redirect()->back()->with('error', 'Error While Creating Reward Point');
            }
        } else {
            return redirect()->back()->with('error', 'Error While Creating Reward Point');
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
        $rewardPoint = $this->rewardPointService->findById($id);
        if ($rewardPoint) {
            return view('rewardPoints.edit', compact('rewardPoint'));
        } else {
            return view('rewardPoints.edit')->with('error', 'No Information Founded !');
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
            $rewardPoint = $this->rewardPointService->upgrade($id, $request);
            if ($rewardPoint) {
                return redirect()->back()->with('success', 'Reward point Update Successfully');
            } else {
                return redirect()->back()->with('error', 'Error While Updating Reward point');
            }
        } else {
            return redirect()->back()->with('error', 'Error While Updating Reward point');
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
        $rewardPoint = $this->rewardPointService->destroy($id);
        if($rewardPoint){
            return redirect()->route('reward-point.index')->with('success','Reward Point Deleted Successfully');
        }
        else {
            return redirect()->route('reward-point.index')->with('error','Something went wrong');
        }

    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Coupon\CreateRequest;
use App\Http\Requests\Coupon\UpdateRequest;
use App\Services\Admin\CouponService;

class CouponController extends Controller
{

    private $couponService ;

    /**
     * CouponController constructor.
     */
    public function __construct(CouponService $couponService) {
        $this->couponService   =  $couponService;
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $coupons = $this->couponService->all() ?? null;
        return view('coupons.index', compact('coupons'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('coupons.create');
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
            $coupon = $this->couponService->insert($request);
            if ($coupon) {
                return redirect()->back()->with('success', 'Coupon Created Successfully');
            } else {
                return redirect()->back()->with('error', 'Error While Creating Coupon');
            }
        } else {
            return redirect()->back()->with('error', 'Error While Creating Coupon');
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
        $coupon = $this->couponService->findById($id);
        if ($coupon) {
            return view('coupons.edit', compact('coupon'));
        } else {
            return view('coupons.edit')->with('error', 'No Information Founded !');
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
            $coupon = $this->couponService->upgrade($id, $request);
            if ($coupon) {
                return redirect()->back()->with('success', 'Coupon Update Successfully');
            } else {
                return redirect()->back()->with('error', 'Error While Updating Coupon');
            }
        } else {
            return redirect()->back()->with('error', 'Error While Updating Coupon');
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
        $coupon = $this->couponService->destroy($id);
        if($coupon){
            return redirect()->route('coupon.index')->with('success','Coupon Deleted Successfully');
        }
        else {
            return redirect()->route('coupon.index')->with('error','Error While Deleting Coupon');
        }

    }
}

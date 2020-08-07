<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Coupon\CreateRequest;
use App\Http\Requests\Coupon\UpdateRequest;
use App\Services\Admin\CategoryService;
use App\Services\Admin\CouponService;
use App\Services\IApplyForCategory;
use App\Services\IApplyForUser;
use App\Services\ICouponType;
use App\Services\Admin\UserService;
use Illuminate\Support\Facades\App;
use Maatwebsite\Excel\Facades\Excel;

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
     * Method: edit
     *
     * @param $id
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id)
    {
        $coupon = $this->couponService->findById($id);
        if ($coupon) {

            if($coupon->apply_for_user == IApplyForUser::APPLY_ON_SPECIFIC_USER){
                if($coupon->list_user_id){
                    $specificUser = App::make(UserService::class)->findById($coupon->list_user_id);
                }
            }
            $users = App::make(UserService::class)->getSelected($coupon->coupon_user_type)->pluck('email', 'id')->toArray();

            if($coupon->apply_for_category == IApplyForCategory::APPLY_ON_SPECIFIC_CATEGORY){
                if($coupon->list_category_id){
                    $specificCategory = App::make(CategoryService::class)->findById($coupon->list_category_id);
                }
            }
            $categories = App::make(CategoryService::class)->getCategory($coupon->coupon_category_type)->pluck('name', 'id')->toArray();
            return view('coupons.edit', compact('coupon', 'users', 'specificUser', 'categories', 'specificCategory'));
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

    /**
     * export list
     */
    public function export(){
        Excel::create('coupons', function($excel) {
            $excel->sheet('coupons', function($sheet) {
                $coupons = $this->couponService->all();
                if(!$coupons->isEmpty()) {

                    foreach ($coupons as $coupon) {
                        $print[] = array('Id' => $coupon->id,
                            'Code' => $coupon->code,
                            'Type' => $coupon->type == ICouponType::FIXED ? 'Fixed' : 'Percentage',
                            'Amount' => $coupon->amount,
                        );
                    }
                    $sheet->fromArray($print);
                }
            });

        })->export('csv');
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\DonationCategory\CreateRequest;
use App\Services\Admin\DonationProductCategoryService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Config;

/**
 * Class DonationCategoryController
 *
 * @package   App\Http\Controllers\Admin
 * @author    Faisal Raza <faisal.raza@gems.techverx.com>
 * @copyright 2020 Techverx.com All rights reserved.
 * @since     May 22, 2020
 * @project   reloop
 */
class DonationCategoryController extends Controller
{
    /**
     * Property: donationProductCategoryService
     *
     * @var DonationProductCategoryService
     */
    private $donationProductCategoryService;

    /**
     * DonationCategoryController constructor.
     * @param DonationProductCategoryService $donationProductCategoryService
     */
    public function __construct(DonationProductCategoryService $donationProductCategoryService) {
        $this->donationProductCategoryService  =   $donationProductCategoryService ;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = $this->donationProductCategoryService->all() ?? null ;
        return view('donationCategories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('donationCategories.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateRequest $request)
    {
        $category = $this->donationProductCategoryService->insert($request);

        if ($category) {
            return redirect()->back()->with('success', Config::get('constants.DONATION_PRODUCT_CREATION_SUCCESS'));
        } else {
            return redirect()->back()->with('error', Config::get('constants.DONATION_PRODUCT_CREATION_ERROR'));
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
        $category = $this->donationProductCategoryService->findById($id);
        if ($category) {
            return view('donationCategories.edit', compact('category'));
        } else {
            return view('donationCategories.edit')->with('error', Config::get('constants.ERROR'));
        }
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
        $category = $this->donationProductCategoryService->upgrade($id,$request);

        if ($category) {
            return redirect()->back()->with('success', Config::get('constants.DONATION_PRODUCT_UPDATE_SUCCESS'));
        } else {
            return redirect()->back()->with('error', Config::get('constants.DONATION_PRODUCT_UPDATE_ERROR'));
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
        $product = $this->donationProductCategoryService->destroy($id);
        if($product){
            return redirect()->route('donation-products.index')->with('success',Config::get('constants.DONATION_PRODUCT_DELETE_SUCCESS'));
        }
        else {
            return redirect()->route('donation-products.index')->with('error',Config::get('constants.DONATION_PRODUCT_UPDATE_ERROR'));
        }
    }
}

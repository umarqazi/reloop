<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\DonationProduct\CreateRequest;
use App\Http\Requests\DonationProduct\UpdateRequest;
use App\Services\Admin\DonationProductCategoryService;
use App\Services\Admin\DonationProductService;
use Illuminate\Support\Facades\Config;
use Maatwebsite\Excel\Facades\Excel;

class DonationProductController extends Controller
{

    private $donationProductService ;
    private $donationProductCategoryService ;

    /**
     * DonationProductController constructor.
     */
    public function __construct(DonationProductService $donationProductService, DonationProductCategoryService $donationProductCategoryService) {
        $this->donationProductService          =   $donationProductService ;
        $this->donationProductCategoryService  =   $donationProductCategoryService ;
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = $this->donationProductService->all() ?? null ;
        return view('donationProducts.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = $this->donationProductCategoryService->all()->pluck('name', 'id')->toArray();
        return view('donationProducts.create', compact('categories'));
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
        $product = $this->donationProductService->create($data);

            if ($product) {
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
        $product = $this->donationProductService->findById($id);
        if ($product) {
            return view('donationProducts.edit', compact('product'));
        } else {
            return view('donationProducts.edit')->with('error', Config::get('constants.ERROR'));
        }
    }

    /**
     * Method: update
     *
     * @param CreateRequest $request
     * @param $id
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(CreateRequest $request, $id)
    {

        $data = $request->except('_token', '_method');

        $product = $this->donationProductService->update($id,$data);

            if ($product) {
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
        $product = $this->donationProductService->destroy($id);
        if($product){
            return redirect()->route('donation-categories.index')->with('success',Config::get('constants.DONATION_PRODUCT_DELETE_SUCCESS'));
        }
        else {
            return redirect()->route('donation-categories.index')->with('error',Config::get('constants.DONATION_PRODUCT_UPDATE_ERROR'));
        }

    }

    /**
     * Method: donationProductCreate
     *
     * @param $categoryId
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function donationProductCreate($categoryId)
    {
        $category = $this->donationProductCategoryService->findById($categoryId);
        return view('donationProducts.create', compact('category'));
    }

    /**
     * export list
     */
    public function export(){
        Excel::create('donationProducts', function($excel) {
            $excel->sheet('donationProducts', function($sheet) {
                $products = $this->donationProductService->all();
                if(!$products->isEmpty()) {

                    foreach ($products as $product) {
                        $print[] = array('Id' => $product->id,
                            'Category' => $product->category->name,
                            'name' => $product->name,
                            'Redeem Points' => $product->redeem_points,
                            'Description' => $product->description,
                            'Status' => $product->status == 0 ? 'Inactive' : 'Active',
                        );
                    }
                    $sheet->fromArray($print);
                }
            });

        })->export('csv');
    }
}

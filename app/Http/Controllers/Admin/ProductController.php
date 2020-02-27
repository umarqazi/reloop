<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Product\CreateRequest;
use App\Http\Requests\Product\UpdateRequest;
use App\Repositories\Admin\CategoryRepo;
use App\Services\Admin\ProductSerivce;
use App\Services\ICategoryType;
use Illuminate\Support\Facades\File;

class ProductController extends Controller
{

    private $categoryRepository ;

    /**
     * ProductController constructor.
     */
    public function __construct(CategoryRepo $categoryRepository) {
        $this->categoryRepository =  $categoryRepository;
        $this->productSerivce = new ProductSerivce();
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = $this->productSerivce->all() ;
        return view('products.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = $this->categoryRepository->getCategory(ICategoryType::PRODUCT)->pluck('name', 'id')->toArray();
        return view('products.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateRequest $request)
    {
        $product = $this->productSerivce->create($request->all());

        if($product){
            return redirect()->route('product.index')->with('success','Product Created Successfully');
        }
        else{
            return redirect()->route('product.index')->with('error','Something went wrong');
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
        $product = $this->productSerivce->findById($id);
        return view('products.edit',compact('product'));
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
        $product = $this->productSerivce->update($id,$request->all());

        if($product){
            return redirect()->route('product.edit',['id'=> $id])->with('success','Product Updated Successfully');
        }
        else {
            return redirect()->back()->with('error','Something went wrong');
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
        $image = $this->productSerivce->findById($id)->avatar ;

        $product = $this->productSerivce->destroy($id);
        if($product){
            //Delete Image
            $image_path = public_path('storage/images/products/').$image;
            if(File::exists($image_path)) {
                File::delete($image_path);
            }
            return redirect()->route('product.index')->with('success','Product Deleted Successfully');
        }
        else {
            return redirect()->route('product.index')->with('error','Something went wrong');
        }

    }
}

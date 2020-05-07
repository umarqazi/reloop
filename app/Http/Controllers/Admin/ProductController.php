<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Product\CreateRequest;
use App\Http\Requests\Product\UpdateRequest;
use App\Services\Admin\CategoryService;
use App\Services\Admin\ProductService;
use App\Services\ICategoryType;
use Illuminate\Support\Facades\File;
use Maatwebsite\Excel\Facades\Excel;

class ProductController extends Controller
{

    private $categoryService ;
    private $productService ;

    /**
     * ProductController constructor.
     */
    public function __construct(ProductService $productService, CategoryService $categoryService) {
        $this->categoryService    =  $categoryService;
        $this->productService     =  $productService;
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = $this->productService->all() ?? null;
        return view('products.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = $this->categoryService->getCategory(ICategoryType::PRODUCT)->pluck('name', 'id')->toArray();
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
        if (!empty($request)) {
            $product = $this->productService->insert($request);
            if ($product) {
                return redirect()->back()->with('success', 'Product Created Successfully');
            } else {
                return redirect()->back()->with('error', 'Error While Creating Product');
            }
        } else {
            return redirect()->back()->with('error', 'Error While Creating Product');
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
        $product = $this->productService->findById($id);
        if ($product) {
            return view('products.edit', compact('product'));
        } else {
            return view('products.edit')->with('error', 'No Information Founded !');
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
            $product = $this->productService->upgrade($id, $request);
            if ($product) {
                return redirect()->back()->with('success', 'Product Update Successfully');
            } else {
                return redirect()->back()->with('error', 'Error While Updating Product');
            }
        } else {
            return redirect()->back()->with('error', 'Error While Updating Product');
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
        $product = $this->productService->destroy($id);
        if($product){
            return redirect()->route('product.index')->with('success','Product Deleted Successfully');
        }
        else {
            return redirect()->route('product.index')->with('error','Something went wrong');
        }

    }

    /**
     * export list
     */
    public function export(){
        Excel::create('products', function($excel) {
            $excel->sheet('products', function($sheet) {
                $products = $this->productService->all();
                if(!$products->isEmpty()) {
                    foreach ($products as $product) {
                        $print[] = array('Id' => $product->id,
                            'Category' => $product->category->name,
                            'name' => $product->name,
                            'price' => $product->price,
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

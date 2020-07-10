<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\MainCategory\CreateRequest;
use App\Http\Requests\MainCategory\UpdateRequest;
use App\Services\Admin\CategoryService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;

/**
 * Class MainCategoryController
 *
 * @package   App\Http\Controllers\Admin
 * @author    Faisal Raza <faisal.raza@gems.techverx.com>
 * @copyright 2020 Techverx.com All rights reserved.
 * @since     Jul 03, 2020
 * @project   reloop
 */
class MainCategoryController extends Controller
{

    /**
     * Property: categoryService
     *
     * @var CategoryService
     */
    private $categoryService;

    public function __construct(CategoryService $categoryService)
    {

        $this->categoryService = $categoryService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $mainCategories = $this->categoryService->all() ?? null;
        if($mainCategories){
            return view('mainCategories.index', compact('mainCategories'));
        }else{
            return view('mainCategories.index', compact('mainCategories'));
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('mainCategories.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateRequest $request)
    {
        if(!empty($request)){
            $mainCategory = $this->categoryService->create($request->all());
            if($mainCategory){
                return redirect()->back()->with('success','Main Category Created Successfully');
            } else {
                return redirect()->back()->with('error','Error While Creating Main Category');
            }
        }else{
            return redirect()->back()->with('error','Error While Creating Main Category');
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
        $mainCategory = $this->categoryService->findById($id);
        if($mainCategory){
            return view('mainCategories.edit', compact('mainCategory'));
        }else{
            return view('mainCategories.edit')->with('empty', 'No Information Founded !');
        }
    }

    /**
     * Method: update
     *
     * @param UpdateRequest $request
     * @param $id
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UpdateRequest $request, $id)
    {
        if(!empty($request)){
            $mainCategory = $this->categoryService->update($id, $request->all());
            if($mainCategory){
                return redirect()->back()->with('success','Main Category Updated Successfully');
            } else {
                return redirect()->back()->with('error','Error While Updating Main Category');
            }
        }else{
            return redirect()->back()->with('error','Error While Updating Main Category');
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
        $request = $this->categoryService->destroy($id);
        if($request){
            return redirect()->back()->with('success','Main Category Deleted Successfully');
        } else {
            return redirect()->back()->with('error','Error While Deleting The Main Category');
        }
    }

    /**
     * Method: getCategories
     *
     * @param $categoryType
     *
     * @return mixed
     */
    public function getCategories($categoryType)
    {
        return $this->categoryService->getCategory($categoryType)->pluck('name', 'id')->toArray();
    }

    /**
     * export list
     */
    public function export(){
        Excel::create('mainCategories', function($excel) {
            $excel->sheet('mainCategories', function($sheet) {
                $mainCategories = $this->categoryService->all();
                if(!$mainCategories->isEmpty()) {

                    foreach ($mainCategories as $category) {
                        $print[] = array('ID' => $category->id,
                            'Name' => $category->name,
                            'Type' => ($category->type == 1) ? 'Subscription' : 'Product',
                            'Status' => ($category->status == 1) ? 'Active' : 'Inactive',
                        );
                    }
                    $sheet->fromArray($print);
                }
            });

        })->export('csv');
    }
}

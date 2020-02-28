<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MaterialCategory\CreateRequest;
use App\Services\Admin\MaterialCategoryService;
use Illuminate\Http\Request;

class MaterialCategoryController extends Controller
{
    private $materialCategoryService;

    /**
     * MaterialCategoryController constructor.
     */
    public function __construct(MaterialCategoryService $materialCategoryService)
    {
        $this->materialCategoryService = $materialCategoryService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $materialCategories = $this->materialCategoryService->all() ?? null;
        if($materialCategories){
            return view('materialCategories.index', compact('materialCategories'));
        }else{
            return view('materialCategories.index', compact('materialCategories'));
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('materialCategories.create');
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
            $materialCategory = $this->materialCategoryService->insert($request);
            if($materialCategory){
                return redirect()->back()->with('success','Material Category Created Successfully');
            } else {
                return redirect()->back()->with('error','Error While Creating Material Category');
            }
        }else{
            return redirect()->back()->with('error','Error While Creating Material Category');
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
        $materialCategory = $this->materialCategoryService->findById($id);
        if($materialCategory){
            return view('materialCategories.edit', compact('materialCategory'));
        }else{
            return view('materialCategories.edit')->with('empty', 'No Information Founded !');
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
        if(!empty($request)){
            $materialCategory = $this->materialCategoryService->upgrade($id, $request);
            if($materialCategory){
                return redirect()->back()->with('success','Material Category Update Successfully');
            } else {
                return redirect()->back()->with('error','Error While Updating Material Category');
            }
        }else{
            return redirect()->back()->with('error','Error While Updating Material Category');
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
        $request = $this->materialCategoryService->destroy($id);
        if($request){
            return redirect()->back()->with('success','Material Category Deleted Successfully');
        } else {
            return redirect()->back()->with('error','Error While Deleting The Material Category');
        }
    }
}

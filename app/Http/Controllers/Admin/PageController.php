<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Page\UpdateRequest;
use App\Services\Admin\PageService;
use Illuminate\Support\Facades\Config;

class PageController extends Controller
{

    private $pageService ;

    /**
     * PageController constructor.
     */
    public function __construct( PageService $pageService) {
        $this->pageService    =     $pageService;
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pages = $this->pageService->all() ?? null;
        return view('content-pages.index', compact('pages'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateRequest $request)
    {
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
        $page = $this->pageService->findById($id);
        if ($page) {
            return view('content-pages.edit', compact('page'));
        } else {
            return view('content-pages.edit')->with('error', 'No Information Founded !');
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
        $data = $request->except('_token', '_method');
        $page = $this->pageService->update($id, $data);

        if ($page) {
                return redirect()->back()->with('success', Config::get('constants.PAGE_UPDATE_SUCCESS'));
            } else {
                return redirect()->back()->with('error', Config::get('constants.PAGE_UPDATE_ERROR'));
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
    }
}

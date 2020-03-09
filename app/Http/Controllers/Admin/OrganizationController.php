<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Organization\CreateRequest;
use App\Http\Requests\Organization\UpdateRequest;
use App\Repositories\Admin\CityRepo;
use App\Repositories\Admin\SectorRepo;
use App\Services\Admin\OrganizationService;
use App\Services\ICategoryType;
use Illuminate\Http\Request;

class OrganizationController extends Controller
{

    private $organizationService ;
    private $sectorRepo ;
    private $cityRepo ;

    /**
     * OrganizationController constructor.
     */
    public function __construct(OrganizationService $productService,SectorRepo $sectorRepo,CityRepo $cityRepo) {
        $this->organizationService   =  $productService;
        $this->sectorRepo            =  $sectorRepo;
        $this->cityRepo              =  $cityRepo;
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $organizations = $this->organizationService->all() ?? null;
        return view('organizations.index', compact('organizations'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $sectors = $this->sectorRepo->all()->pluck('name', 'id')->toArray();
        $cities  = $this->cityRepo->all()->pluck('name', 'id')->toArray();
        return view('organizations.create', compact('sectors','cities'));
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
            $organization = $this->organizationService->insert($request);
            if ($organization) {
                return redirect()->back()->with('success', 'Organization Created Successfully');
            } else {
                return redirect()->back()->with('error', 'Error While Creating Organization');
            }
        } else {
            return redirect()->back()->with('error', 'Error While Creating Organization');
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
        $sectors = $this->sectorRepo->all()->pluck('name', 'id')->toArray();
        $cities  = $this->cityRepo->all()->pluck('name', 'id')->toArray();
        $organization = $this->organizationService->findById($id);
        if ($organization) {
            return view('organizations.edit', compact('organization','sectors','cities'));
        } else {
            return view('organizations.edit')->with('error', 'No Information Founded !');
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
            $product = $this->organizationService->upgrade($id, $request);
            if ($product) {
                return redirect()->back()->with('success', 'Organization Update Successfully');
            } else {
                return redirect()->back()->with('error', 'Error While Updating Organization');
            }
        } else {
            return redirect()->back()->with('error', 'Error While Updating Organization');
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
        $organization = $this->organizationService->delete($id);
        if($organization){
            return redirect()->route('organization.index')->with('success','Organization Deleted Successfully');
        }
        else {
            return redirect()->route('organization.index')->with('error','Something went wrong');
        }

    }
}

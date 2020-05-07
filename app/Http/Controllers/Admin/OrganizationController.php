<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Organization\CreateRequest;
use App\Http\Requests\Organization\UpdateRequest;
use App\Repositories\Admin\CityRepo;
use App\Repositories\Admin\DistrictRepo;
use App\Repositories\Admin\SectorRepo;
use App\Services\Admin\OrganizationService;
use App\Services\ICategoryType;
use App\Services\IUserStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Maatwebsite\Excel\Facades\Excel;

class OrganizationController extends Controller
{

    private $organizationService ;
    private $sectorRepo ;
    private $cityRepo ;
    private $districtRepo ;

    /**
     * OrganizationController constructor.
     */
    public function __construct(OrganizationService $productService,SectorRepo $sectorRepo,CityRepo $cityRepo,DistrictRepo $districtRepo) {
        $this->organizationService   =  $productService;
        $this->sectorRepo            =  $sectorRepo;
        $this->cityRepo              =  $cityRepo;
        $this->districtRepo          =  $districtRepo;
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
        $sectors    = $this->sectorRepo->all()->pluck('name', 'id')->toArray();
        $noOfBranches   = $units = Config::get('global.Branches');
        $noOfEmployees  = $units = Config::get('global.Employees');
        $cities     = $this->cityRepo->all()->pluck('name', 'id')->toArray();
        $districts  = $this->districtRepo->all()->pluck('name', 'id')->toArray();
        return view('organizations.create', compact(
            'sectors','cities','districts', 'noOfBranches', 'noOfEmployees'
        ));
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
        $districts  = $this->districtRepo->all()->pluck('name', 'id')->toArray();
        $noOfBranches   = $units = Config::get('global.Branches');
        $noOfEmployees  = $units = Config::get('global.Employees');
        $organization = $this->organizationService->findById($id);
        if ($organization) {
            return view('organizations.edit', compact(
                'organization','sectors','cities','districts', 'noOfBranches', 'noOfEmployees'
            ));
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

    /**
     * export list
     */
    public function export(){
        Excel::create('organizations', function($excel) {
            $excel->sheet('organizations', function($sheet) {
                $organizations = $this->organizationService->all();

                foreach($organizations as $organization){
                    $print[] = array('Id'                  => $organization->id,
                                     'name'                => $organization->name,
                                     'email'               => $organization->users->first()->email ,
                                     'phone number'        => $organization->users->first()->phone_number,
                                     'Number of branches'  => $organization->no_of_branches,
                                     'Number of employees' => $organization->no_of_employees,
                                     'Status'              => $organization->users->first()->status == IUserStatus::ACTIVE ? 'Active' : 'Inactive',
                                     'Sector'              => $organization->sector->name,
                                     'Type'                => ($organization->users->first()->addresses->first()->type=='1') ? 'Villa' : 'Apartment',
                                     'No of Bedrooms'      => $organization->users->first()->addresses->first()->no_of_bedrooms,
                                     'No of Occupants'     => $organization->users->first()->addresses->first()->no_of_occupants,
                                     'City'                => $organization->users->first()->addresses->first()->city->name,
                                     'District'            => $organization->users->first()->addresses->first()->district->name,
                                     'Street'              => $organization->users->first()->addresses->first()->street,
                                     'Floor'               => $organization->users->first()->addresses->first()->floor,
                                     'Unit Number'         => $organization->users->first()->addresses->first()->unit_number,
                                     'Location'            => $organization->users->first()->addresses->first()->location,

                    ) ;
                }

                $sheet->fromArray($print);

            });

        })->export('csv');
    }
}

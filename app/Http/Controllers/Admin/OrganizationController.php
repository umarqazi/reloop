<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Organization\CreateRequest;
use App\Http\Requests\Organization\UpdateRequest;
use App\Repositories\Admin\CityRepo;
use App\Repositories\Admin\DistrictRepo;
use App\Repositories\Admin\SectorRepo;
use App\Services\Admin\CollectionRequestService;
use App\Services\Admin\OrganizationService;
use App\Services\RequestCollectionService;
use App\Services\EnvironmentalStatService;
use App\Services\ICategoryType;
use App\Services\IUserStatus;
use App\Services\OrderService;
use App\Services\TransactionService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
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
        $organization = $this->organizationService->findById($id);
        $organization = $organization->users->first();
        return view('organizations.view',compact('organization'));
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
        $orgUserId = $organization->users->where('user_type', 2)->first()->id;

        $totalTrips = App::make(CollectionRequestService::class)->calculateTripsWeights($orgUserId);
        $rewardPoints = $totalTrips->sum('reward_points');
        $totalHouseholdsTrips = App::make(CollectionRequestService::class)->calculateHouseholdsTripsWeights($orgUserId);
        $totalHouseholdsRewardPoints = $totalHouseholdsTrips->sum('reward_points');
        $totalWeight = App::make(RequestCollectionService::class)->calculateWeight($orgUserId);
        $totalHouseholdsWeight = App::make(RequestCollectionService::class)->calculateHouseholdsWeight($orgUserId);
        $totalOrders = App::make(OrderService::class)->totalOrders($orgUserId);
        $totalBills = App::make(TransactionService::class)->userBillings($orgUserId);
        $totalBills = $totalBills->sum('total');
        $environmentalStats = App::make(EnvironmentalStatService::class)->userStats($orgUserId);
        $orgUsersEnvironmentalStats = App::make(EnvironmentalStatService::class)->orgUsersEnvironmentalStats($orgUserId);
        if ($organization) {
            return view('organizations.edit', compact(
                'organization','sectors','cities','districts', 'noOfBranches', 'noOfEmployees', 'totalTrips',
                'rewardPoints', 'totalWeight', 'totalOrders', 'totalBills', 'environmentalStats', 'totalHouseholdsWeight',
                'totalHouseholdsTrips', 'totalHouseholdsRewardPoints', 'orgUsersEnvironmentalStats'
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
                if(!$organizations->isEmpty()) {

                    foreach ($organizations as $organization) {

                        $orgUser = $organization->users->where('user_type', 2)->first();
                        $totalTrips = App::make(CollectionRequestService::class)->calculateTripsWeights($orgUser->id);
                        $rewardPoints = $totalTrips->sum('reward_points');
                        $totalHouseholdsTrips = App::make(CollectionRequestService::class)->calculateHouseholdsTripsWeights($orgUser->id);
                        $totalHouseholdsRewardPoints = $totalHouseholdsTrips->sum('reward_points');
                        $totalWeight = App::make(RequestCollectionService::class)->calculateWeight($orgUser->id);
                        $totalHouseholdsWeight = App::make(RequestCollectionService::class)->calculateHouseholdsWeight($orgUser->id);
                        $totalOrders = App::make(OrderService::class)->totalOrders($orgUser->id);
                        $totalBills = App::make(TransactionService::class)->userBillings($orgUser->id);
                        $totalBills = $totalBills->sum('total');
                        $environmentalStats = App::make(EnvironmentalStatService::class)->userStats($orgUser->id);
                        $orgUsersEnvironmentalStats = App::make(EnvironmentalStatService::class)->orgUsersEnvironmentalStats($orgUser->id);

                        $print[] = array('Id' => $organization->id,
                            'name' => $organization->name,
                            'email' => $orgUser->email,
                            'phone number' => $orgUser->phone_number,
                            'Number of branches' => $organization->no_of_branches,
                            'Number of employees' => $organization->no_of_employees,
                            'Status' => $orgUser->status == IUserStatus::ACTIVE ? 'Active' : 'Inactive',
                            'Sector' => $organization->sector->name,
                            'Type' => $orgUser->addresses->first()->type,
                            'No of Bedrooms' => $orgUser->addresses->first()->no_of_bedrooms,
                            'No of Occupants' => $orgUser->addresses->first()->no_of_occupants,
                            'City' => $orgUser->addresses->first()->city->name,
                            'District' => $orgUser->addresses->first()->district->name,
                            'Street' => $orgUser->addresses->first()->street,
                            'Floor' => $orgUser->addresses->first()->floor,
                            'Unit Number' => $orgUser->addresses->first()->unit_number,
                            'Location' => $orgUser->addresses->first()->location,
                            'Total Trips' => count($totalTrips),
                            'Total Household Trips' => count($totalHouseholdsTrips),
                            'Total Points' => $rewardPoints,
                            'Total Recycled (Kg)' => ($totalWeight) ?? 0,
                            'Total Household Recycled (kg)' => ($totalHouseholdsWeight) ?? 0,
                            'Total Product Orders' => count($totalOrders) ?? 0,
                            'Total Bills' => $totalBills,
                            'Total Trees Saved' => ($environmentalStats->trees_saved) ?? 0,
                            'Total CO2 Emission Reduced' => ($environmentalStats->co2_emission_reduced) ?? 0,
                            'Total Oil Saved' => ($environmentalStats->oil_saved) ?? 0,
                            'Total Water Saved' => ($environmentalStats->water_saved) ?? 0,
                            'Total Landfill Space Saved' => ($environmentalStats->landfill_space_saved) ?? 0,
                            'Total Electricity Saved' => ($environmentalStats->electricity_saved) ?? 0,
                            'Total Household Trees Saved' => ($orgUsersEnvironmentalStats->trees_saved) ?? 0,
                            'Total Household Co2 Emission Reduced' => ($orgUsersEnvironmentalStats->co2_emission_reduced) ?? 0,
                            'Total Household Oil Saved' => ($orgUsersEnvironmentalStats->oil_saved) ?? 0,
                            'Total Household Water Saved' => ($orgUsersEnvironmentalStats->water_saved) ?? 0,
                            'Total Household Landfill Space Saved' => ($orgUsersEnvironmentalStats->landfill_space_saved) ?? 0,
                            'Total Household Electricity Saved' => ($orgUsersEnvironmentalStats->electricity_saved) ?? 0,
                        );
                    }
                    $sheet->fromArray($print);
                }
            });

        })->export('csv');
    }

    /**
     * Method: import
     * Import organizations form the csv file.
     *
     * @param  Request  $request
     *
     * @return void
     */
    public function import(Request $request)
    {
        $this->organizationService->import($request);
    }
}

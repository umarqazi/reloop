<?php


namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\CreateRequest;
use App\Http\Requests\User\UpdateRequest;
use App\Services\Admin\CityService;
use App\Services\Admin\CollectionRequestService;
use App\Services\Admin\DistrictService;
use App\Services\EnvironmentalStatService;
use App\Services\OrderService;
use App\Services\Admin\RequestCollectionService;
use App\Services\Admin\UserDonationService;
use App\Services\Admin\UserSubscriptionService;
use App\Services\IUserSubscriptionStatus;
use App\Services\IUserType;
use App\Services\Admin\UserService;
use App\Services\TransactionService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Maatwebsite\Excel\Facades\Excel;

class UserController extends Controller
{
    private $userService;
    private $cityService;
    private $districtService;
    private $userSubscriptionService;
    private $userDonationService;

    public function __construct(UserService $userService,CityService $cityService,DistrictService $districtService,UserSubscriptionService $userSubscriptionService, UserDonationService $userDonationService)
    {
        $this->userService             = $userService;
        $this->cityService             = $cityService;
        $this->districtService         = $districtService;
        $this->userSubscriptionService = $userSubscriptionService;
        $this->userDonationService     = $userDonationService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $type = IUserType::HOUSE_HOLD ?? null;
        $users = $this->userService->getSelected($type) ?? null;
        if($users){
            return view('users.index', compact('users', 'type'));
        }else{
            return view('users.index', compact('users', 'type'));
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $type = IUserType::HOUSE_HOLD;
        $cities  = $this->cityService->all()->pluck('name', 'id')->toArray();
        $districts = $this->districtService->all()->pluck('name', 'id')->toArray();
        return view('users.create', compact('type','cities','districts'));
    }

    /**
     * @param CreateRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(CreateRequest $request)
    {
        if(!empty($request)){
            $user = $this->userService->insert($request);
            if($user){
                $user->assignRole('user');
                return redirect()->back()->with('success','User Created Successfully');
            } else {
                return redirect()->back()->with('error','Error While Creating User');
            }
        }else{
            return redirect()->back()->with('error','Error While Creating User');
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
        $user = $this->userService->findById($id) ;
        return view('users.view',compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $type = IUserType::HOUSE_HOLD;
        $user = $this->userService->findById($id);
        $cities  = $this->cityService->all()->pluck('name', 'id')->toArray();
        $districts = $this->districtService->all()->pluck('name', 'id')->toArray();
        $totalTrips = App::make(CollectionRequestService::class)->calculateTripsWeights($user->id);
        $rewardPoints = $totalTrips->sum('reward_points');
        $totalWeight = App::make(RequestCollectionService::class)->calculateWeight($user->id);
        $totalOrders = App::make(OrderService::class)->totalOrders($user->id);
        $totalBills = App::make(TransactionService::class)->userBillings($user->id);
        $totalBills = $totalBills->sum('total');
        $environmentalStats = App::make(EnvironmentalStatService::class)->userStats($user->id);
        if($user){
            return view('users.edit', compact(
                'user', 'type','cities','districts', 'totalTrips', 'totalWeight', 'totalOrders', 'rewardPoints',
                'totalBills', 'environmentalStats'
            ));
        }else{
            return view('users.edit')->with('error', 'No Information Founded !');
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
        if(!empty($request)){
            $user = $this->userService->upgrade($id, $request);
            if($user){
                return redirect()->back()->with('success','User Update Successfully');
            } else {
                return redirect()->back()->with('error','Error While Updating User');
            }
        }else{
            return redirect()->back()->with('error','Error While Updating User');
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
        $request = $this->userService->destroy($id);
        if($request){
            return redirect()->back()->with('success','User Deleted Successfully');
        } else {
            return redirect()->back()->with('error','Error While Deleting The User');
        }
    }

    /**
     * get all users with their subscriptions
     */
    public function userSubscription()
    {
        $userSubscriptions = $this->userSubscriptionService->all();
        return view('users.user-subscription',compact('userSubscriptions'));
    }

    /**
     * get all users with their donations
     */
    public function userDonation()
    {
        $userDonations = $this->userDonationService->all();
        return view('users.user-donation',compact('userDonations'));
    }

    /**
     * export list
     */
    public function export(){
        Excel::create('users', function($excel) {
            $excel->sheet('users', function($sheet) {
                $users = $this->userService->getSelected(IUserType::HOUSE_HOLD) ;

                foreach($users as $user){
                    $totalTrips = App::make(CollectionRequestService::class)->calculateTripsWeights($user->id);
                    $rewardPoints = $totalTrips->sum('reward_points');
                    $totalWeight = App::make(RequestCollectionService::class)->calculateWeight($user->id);
                    $totalOrders = App::make(OrderService::class)->totalOrders($user->id);
                    $totalBills = App::make(TransactionService::class)->userBillings($user->id);
                    $totalBills = $totalBills->sum('total');
                    $environmentalStats = App::make(EnvironmentalStatService::class)->userStats($user->id);
                    $print[] = array( 'User ID'         => $user->id,
                                      'User Email'      => $user->email,
                                      'User Name'       => $user->first_name.' '.$user->last_name,
                                      'User Type'       => ($user->user_type == IUserType::HOUSE_HOLD) ? 'House Hold' : (($user->user_type == IUserType::DRIVER) ? 'Driver' : (($user->user_type == IUserType::SUPERVISOR) ? 'Supervisor' : '')) ,
                                      'Rewards Points'  => $user->reward_points ?? '0',
                                      'User City'       => ($user->addresses->first()) ? $user->addresses->first()->city->name : 'Not found',
                                      'User District'   => ($user->addresses->first()) ? $user->addresses->first()->district->name : 'Not found',
                                      'Location'        => ($user->addresses->first()) ? $user->addresses->first()->location : 'Not found',
                                      'Type'            => ($user->addresses->first()) ? (($user->addresses->first()->type=='villa') ? 'Villa' : 'Apartment') : 'Not found',
                                      'No of Bedrooms'  => ($user->addresses->first()) ? $user->addresses->first()->no_of_bedrooms : 'Not found',
                                      'No of Occupants' => ($user->addresses->first()) ? $user->addresses->first()->no_of_occupants : 'Not found',
                                      'Street'          => ($user->addresses->first()) ? $user->addresses->first()->street : 'Not found',
                                      'Floor'           => ($user->addresses->first()) ? $user->addresses->first()->floor : 'Not found',
                                      'Unit Number'     => ($user->addresses->first()) ? $user->addresses->first()->unit_number : 'Not found',
                                      'User Status'     => ($user->status == 1) ? 'Active' : 'Inactive',
                                      'Reports'         => $user->reports == \App\Services\IUserReports::DISABLE ?  'Disable' : 'Enable' ,
                                      'Total Trips '    => count($totalTrips),
                                      'Total Points'    => $rewardPoints,
                                      'Total Weight'    => $totalWeight,
                                      'Total Orders '   => count($totalOrders),
                                      'Total Bills '    => $totalBills,
                                      'Trees Saved'     => ($environmentalStats->trees_saved) ?? 0,
                                      'Co2 Emission Reduced' => ($environmentalStats->co2_emission_reduced) ?? 0,
                                      'Oil Saved'            => ($environmentalStats->oil_saved) ?? 0,
                                      'Water Saved'          => ($environmentalStats->water_saved) ?? 0,
                                      'Landfill Space Saved' => ($environmentalStats->landfill_space_saved) ?? 0,
                                      'Electricity Saved'    => ($environmentalStats->electricity_saved) ?? 0,
                        ) ;
                }

                $sheet->fromArray($print);

            });

        })->export('csv');
    }

    /**
     * export list
     */
    public function userSubscriptionExport(){
        Excel::create('userSubscriptions', function($excel) {
            $excel->sheet('userSubscriptions', function($sheet) {
                $userSubscriptions = $this->userSubscriptionService->all();
                if(!$userSubscriptions->isEmpty()) {

                    foreach ($userSubscriptions as $userSubscription) {
                        switch ($userSubscription->status){
                            case (IUserSubscriptionStatus::ACTIVE):
                                $status = 'Active';
                                break;
                            case (IUserSubscriptionStatus::PENDING):
                                $status = 'Pending';
                                break;
                            case (IUserSubscriptionStatus::COMPLETED):
                                $status = 'Completed';
                                break;
                            case (IUserSubscriptionStatus::EXPIRED):
                                $status = 'Expired';
                                break;
                        }
                        $print[] = array(
                            'User ID' => $userSubscription->user->id,
                            'User Email' => $userSubscription->user->email,
                            'Name' => ($userSubscription->user->user_type == 1) ?
                                       $userSubscription->user->first_name . ' ' . $userSubscription->user->last_name :
                                       $userSubscription->user->organization->name,
                            'User Type' => $userSubscription->user->user_type == IUserType::HOUSE_HOLD ? 'HouseHold' : 'Organization',
                            'Phone Number' => $userSubscription->user->phone_number,
                            'Subscription Name' => $userSubscription->subscription->name,
                            'Subscription Price' => $userSubscription->subscription->price,
                            'Total Trip(s)' => $userSubscription->subscription->request_allowed,
                            'Remaining Trip(s)' => $userSubscription->trips,
                            'Starting Date' => $userSubscription->start_date,
                            'Ending Date' => $userSubscription->end_date,
                            'Status' => $status,
                            'City' => $userSubscription->user->addresses->first()->city->name,
                            'District' => $userSubscription->user->addresses->first()->district->name,
                        );
                    }
                    $sheet->fromArray($print);
                }
            });

        })->export('csv');
    }

    /**
     * export list
     */
    public function userDonationExport(){
        Excel::create('userDonations', function($excel) {
            $excel->sheet('userDonations', function($sheet) {
                $userDonations = $this->userDonationService->all();;
                if(!$userDonations->isEmpty()) {

                    foreach ($userDonations as $userDonation) {
                        $print[] = array(
                            'User ID' => $userDonation->user->id,
                            'User Email' => $userDonation->user->email,
                            'Name' => ($userDonation->user->user_type == 1) ?
                                             $userDonation->user->first_name . ' ' . $userDonation->user->last_name :
                                             $userDonation->user->organization->name,
                            'User Type' => ($userDonation->user->user_type == IUserType::HOUSE_HOLD ? 'HouseHold' : 'Organization'),
                            'Phone Number' => $userDonation->user->phone_number,
                            'Reward Category' => $userDonation->donationProduct->category->name,
                            'Reward Item' => $userDonation->donationProduct->name,
                            'Redeemed Points' => $userDonation->donationProduct->redeem_points,
                            'City' => $userDonation->user->addresses->first()->city->name,
                            'District' => $userDonation->user->addresses->first()->district->name,
                            'Date - Time' => $userDonation->created_at,
                        );
                    }
                    $sheet->fromArray($print);
                }
            });

        })->export('csv');
    }
}

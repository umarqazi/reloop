<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ContactAdmin\ContactAdmin;
use App\Http\Requests\Supervisor\CreateRequest;
use App\Http\Requests\Supervisor\UpdateRequest;
use App\Services\Admin\CityService;
use App\Services\Admin\DistrictService;
use App\Services\IUserType;
use App\Services\Admin\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Maatwebsite\Excel\Facades\Excel;

class SupervisorController extends Controller
{
    private $userService;
    private $cityService;
    private $districtService;

    public function __construct(UserService $userService,CityService $cityService,DistrictService $districtService)
    {
        $this->userService     = $userService;
        $this->cityService     = $cityService;
        $this->districtService = $districtService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $type = IUserType::SUPERVISOR ?? null;
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
        $type = IUserType::SUPERVISOR;
        $cities  = $this->cityService->all()->pluck('name', 'id')->toArray();
        $districts  = $this->districtService->all();
        return view('users.create', compact('type','cities','districts'));
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
            $user = $this->userService->insert($request);
            if($user){
                $user->assignRole('supervisor');
                return redirect()->back()->with('success','Supervisor Created Successfully');
            } else {
                return redirect()->back()->with('error','Error While Creating Supervisor');
            }
        }else{
            return redirect()->back()->with('error','Error While Creating Supervisor');
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
        $type = IUserType::SUPERVISOR;
        $user = $this->userService->findById($id);
        $district_ids =  array();
        $cities  = $this->cityService->all()->pluck('name', 'id')->toArray();
        for($i = 0 ; $i < sizeof($user->addresses) ; $i++ ){
             $district_ids[$i] = $user->addresses[$i]->district_id ;
             $city_id = $user->addresses[$i]->city_id;
        }

        $districts  = $this->cityService->getRelatedDistricts($city_id)->pluck('name', 'id')->toArray();

        if($user){
            return view('users.edit', compact('user', 'type','cities','districts','district_ids'));
        }else{
            return view('users.edit')->with('empty', 'No Information Founded !');
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
                return redirect()->back()->with('success','Supervisor Update Successfully');
            } else {
                return redirect()->back()->with('error','Error While Updating Supervisor');
            }
        }else{
            return redirect()->back()->with('error','Error While Updating Supervisor');
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
            return redirect()->back()->with('success','Supervisor Deleted Successfully');
        } else {
            return redirect()->back()->with('error','Error While Deleting The Supervisor');
        }
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function contactAdminForm(){

        return view('users.contact-admin');

    }

    /**
     * @param ContactAdmin $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function contactAdmin(ContactAdmin $request){
        $data = $request->except('_token') ;
        $contactAdmin = $this->userService->contactAdmin($data);
        if($contactAdmin){
            return redirect()->back()->with('success', Config::get('constants.CONTACT_US_SUCCESS'));
        }
        else{
            return redirect()->back()->with('success', Config::get('constants.CONTACT_US_ERROR'));
        }
    }

    /**
     * export list
     */
    public function export(){
        Excel::create('supervisors', function($excel) {
            $excel->sheet('supervisors', function($sheet) {
                $users = $this->userService->getSelected(IUserType::SUPERVISOR) ;
                if(!$users->isEmpty()) {

                    foreach ($users as $user) {
                        $print[] = array('User ID' => $user->id,
                            'User Email' => $user->email,
                            'User Type' => ($user->user_type == IUserType::HOUSE_HOLD) ? 'House Hold' : (($user->user_type == IUserType::DRIVER) ? 'Driver' : (($user->user_type == IUserType::SUPERVISOR) ? 'Supervisor' : '')),
                            'Rewards Points' => $user->reward_points ?? '0',
                            'User Status' => ($user->status == 1) ? 'Active' : 'Inactive',
                        );
                    }
                    $sheet->fromArray($print);
                }
            });

        })->export('csv');
    }
}

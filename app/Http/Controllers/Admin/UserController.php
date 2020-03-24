<?php


namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\CreateRequest;
use App\Http\Requests\User\UpdateRequest;
use App\Services\Admin\CityService;
use App\Services\Admin\DistrictService;
use App\Services\Admin\UserSubscriptionService;
use App\Services\IUserType;
use App\Services\Admin\UserService;
use Illuminate\Http\Request;

class UserController extends Controller
{
    private $userService;
    private $cityService;
    private $districtService;
    private $userSubscriptionService;

    public function __construct(UserService $userService,CityService $cityService,DistrictService $districtService,UserSubscriptionService $userSubscriptionService)
    {
        $this->userService             = $userService;
        $this->cityService             = $cityService;
        $this->districtService         = $districtService;
        $this->userSubscriptionService = $userSubscriptionService;
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
        $type = IUserType::HOUSE_HOLD;
        $user = $this->userService->findById($id);
        $cities  = $this->cityService->all()->pluck('name', 'id')->toArray();
        $districts = $this->districtService->all()->pluck('name', 'id')->toArray();
        if($user){
            return view('users.edit', compact('user', 'type','cities','districts'));
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
}

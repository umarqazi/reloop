<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\CreateRequest;
use App\Http\Requests\User\UpdateRequest;
use App\Services\IUserType;
use App\Services\Admin\UserService;
use Illuminate\Http\Request;

class DriverController extends Controller
{
    private $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $type = IUserType::DRIVER ?? null;
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
        $type = IUserType::DRIVER;
        return view('users.create', compact('type'));
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
                $user->assignRole('user');
                return redirect()->back()->with('success','Driver Created Successfully');
            } else {
                return redirect()->back()->with('error','Error While Creating Driver');
            }
        }else{
            return redirect()->back()->with('error','Error While Creating Driver');
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
        $type = IUserType::DRIVER;
        $user = $this->userService->findById($id);
        if($user){
            return view('users.edit', compact('user', 'type'));
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
                return redirect()->back()->with('success','Driver Update Successfully');
            } else {
                return redirect()->back()->with('error','Error While Updating Diver');
            }
        }else{
            return redirect()->back()->with('error','Error While Updating Driver');
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
            return redirect()->back()->with('success','Driver Deleted Successfully');
        } else {
            return redirect()->back()->with('error','Error While Deleting The Driver');
        }
    }
}

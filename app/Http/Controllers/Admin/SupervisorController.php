<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\CreateRequest;
use App\Http\Requests\User\UpdateRequest;
use App\Services\IUserType;
use App\Services\Admin\UserService;
use Illuminate\Http\Request;

class SupervisorController extends Controller
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
        $data = $request->except('_token');
        if(!empty($data)){
            $user = $this->userService->create($data);
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
        $data = $request->except('_token', '_method', 'email');
        if(!empty($data)){
            $user = $this->userService->update($id, $data);
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
}
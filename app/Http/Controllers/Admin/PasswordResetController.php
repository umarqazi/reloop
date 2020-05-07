<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\PasswordReset\UpdateRequest;
use App\Services\Admin\PasswordResetService;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Request;
use Maatwebsite\Excel\Facades\Excel;

class passwordResetController extends Controller
{

    private $passwordResetService ;

    /**
     * passwordResetController constructor.
     */
    public function __construct(PasswordResetService $passwordResetService) {
        $this->passwordResetService  =  $passwordResetService;
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $requests = $this->passwordResetService->all() ?? null;
        return view('users.password-requests', compact('requests'));
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
        $request = $this->passwordResetService->findById($id);
        if ($request) {
            return view('users.password-reset', compact('request'));
        } else {
            return view('users.password-reset')->with('error', Config::get('constants.ERROR'));
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
            $password = $this->passwordResetService->upgrade($id, $request);
            if ($password) {
                return redirect()->back()->with('success', Config::get('constants.PASSWORD_UPDATED_SUCCESSFULLY'));
            } else {
                return redirect()->back()->with('error', Config::get('constants.PASSWORD_UPDATE_ERROR'));
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

    /**
     * export list
     */
    public function export(){
        Excel::create('passwordResetRequests', function($excel) {
            $excel->sheet('passwordResetRequests', function($sheet) {
                $requests = $this->passwordResetService->all();
                if(!$requests->isEmpty()){

                    foreach($requests as $request){
                        $print[] = array( 'Request ID'       => $request->id,
                                          'User Email'       => $request->email,
                                          'Request Status'   => ($request->status == 0) ? 'New' : 'Completed' ,
                        ) ;
                    }
                    $sheet->fromArray($print);
                }
            });

        })->export('csv');
    }
}

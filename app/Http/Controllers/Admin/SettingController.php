<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Setting\CreateRequest;
use App\Http\Requests\Setting\UpdateRequest;
use App\Services\Admin\SettingService;
use Illuminate\Support\Facades\Config;
use Maatwebsite\Excel\Facades\Excel;

class SettingController extends Controller
{

    private $settingService ;

    /**
     * SettingController constructor.
     */
    public function __construct(SettingService $settingService) {
        $this->settingService   =  $settingService;
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $settings = $this->settingService->all() ?? null;
        return view('settings.index', compact('settings'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('settings.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateRequest $request)
    {
        $data = $request->except('_token') ;
        $setting = $this->settingService->create($data);

        if ($setting) {
            return redirect()->back()->with('success', Config::get('constants.SETTING_CREATION_SUCCESS'));
        } else {
            return redirect()->back()->with('error', Config::get('constants.SETTING_CREATION_ERROR'));
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
        $setting = $this->settingService->findById($id);
        if ($setting) {
            return view('settings.edit', compact('setting'));
        } else {
            return view('settings.edit')->with('error', Config::get('constants.ERROR'));
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
        $setting = $this->settingService->update($id,$data);
            if ($setting) {
                return redirect()->back()->with('success', Config::get('constants.SETTING_UPDATE_SUCCESS'));
            } else {
                return redirect()->back()->with('error', Config::get('constants.SETTING_UPDATE_ERROR'));
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
        Excel::create('settings', function($excel) {
            $excel->sheet('settings', function($sheet) {
                $settings = $this->settingService->all();

                foreach($settings as $setting){
                    $print[] = array( 'Id'        => $setting->id,
                                      'Keys'      => $setting->keys,
                                      'Values'    => $setting->values,
                    ) ;
                }

                $sheet->fromArray($print);

            });

        })->export('csv');
    }
}

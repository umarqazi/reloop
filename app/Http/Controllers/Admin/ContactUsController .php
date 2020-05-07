<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\Admin\ContactUsService;
use Maatwebsite\Excel\Facades\Excel;

class ContactUsController extends Controller
{

    private $categoryService ;

    /**
     * ContactUsController constructor.
     */
    public function __construct(ContactUsService $contactUsService) {
        $this->contactUsService    =  $contactUsService ;
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $contactUs = $this->contactUsService->all();
        return view('contact-us.index',compact('contactUs'));
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
        $contactUs = $this->contactUsService->findById($id);
        return view('contact-us.view',compact('contactUs'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
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
        Excel::create('contactUs', function($excel) {
            $excel->sheet('contactUs', function($sheet) {
                $contactUs = $this->contactUsService->all();
                if(!$contactUs->isEmpty()) {

                    foreach ($contactUs as $contact) {
                        $print[] = array('Id' => $contact->id,
                            'Email' => $contact->email,
                            'Subject' => $contact->subject,
                        );
                    }
                    $sheet->fromArray($print);
                }
            });

        })->export('csv');
    }
}

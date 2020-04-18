<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Question\CreateRequest;
use App\Http\Requests\Question\UpdateRequest;
use App\Services\Admin\QuestionService;
use Illuminate\Support\Facades\Config;
use Maatwebsite\Excel\Facades\Excel;

class QuestionController extends Controller
{

    private $questionService ;

    /**
     * QuestionController constructor.
     */
    public function __construct(QuestionService $questionService) {
        $this->questionService  = $questionService ;
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $questions = $this->questionService->all() ?? null;
        return view('questions.index', compact('questions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('questions.create');
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
          $product = $this->questionService->create($data);

            if ($product) {
                return redirect()->back()->with('success', Config::get('constants.QUESTION_CREATION_SUCCESS'));
            } else {
                return redirect()->back()->with('error', Config::get('constants.QUESTION_CREATION_ERROR'));
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
        $question = $this->questionService->findById($id);
        if ($question) {
            return view('questions.edit', compact('question'));
        } else {
            return view('questions.edit')->with('error', Config::get('constants.ERROR'));
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
            $data = $request->except('_token','_method') ;
            $question = $this->questionService->update($id,$data);
            if ($question) {
                return redirect()->back()->with('success', Config::get('constants.QUESTION_UPDATE_SUCCESS'));
            } else {
                return redirect()->back()->with('error', Config::get('constants..QUESTION_UPDATE_ERROR'));
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
        $question = $this->questionService->destroy($id);
        if($question){
            return redirect()->route('questions.index')->with('success',Config::get('constants.QUESTION_DELETE_SUCCESS'));
        }
        else {
            return redirect()->route('questions.index')->with('error',Config::get('constants.QUESTION_DELETE_ERROR'));
        }

    }

    /**
     * export list
     */
    public function export(){
        Excel::create('questions', function($excel) {
            $excel->sheet('questions', function($sheet) {
                $questions = $this->questionService->all();

                foreach($questions as $question){
                    $print[] = array( 'Id'        => $question->id,
                                      'Question'  => $question->question,
                    ) ;
                }

                $sheet->fromArray($print);

            });

        })->export('csv');
    }
}

<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreQuestionRequest;
//use App\Question;
//use App\Topic;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Repositories\QuestionRepository;





class QuestionsController extends Controller
{
    protected  $questionRepository;
    
    /**
     * 依赖注入
     * QuestionsController constructor.
     * @param \App\Repositories\QuestionRepository $questionRepository
     */
    public function __construct(QuestionRepository $questionRepository)
    {
        $this->middleware('auth')->except(['index','show']);
        $this->questionRepository = $questionRepository;
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return 'index';
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('questions.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    //public function store(Request $request)
    public function store(StoreQuestionRequest $request)
    {
        /*$rules = [
           'title'  =>'required|min:6|max:196',
           'body'   =>'required|min:20',
           
        ];*/
        /*$message = [
            'body.required'=>'内容不得为空' ,
            'body.min'=>'内容不得少于20个字符' ,
        ];*/
        //自动过滤掉token值
        //$this->validate($request,$rules,$message);
        
        $topics = $this->questionRepository->normailizeTopic($request->get('topics'));
        $data = $request->all();
        $save = [
            'title'     =>$data['title'],
            'body'      =>$data['body'],
            'user_id'   =>Auth::id()
        ];
        //$rs = Question::create($save);
        $rs = $this->questionRepository->create($save);
    
        $rs->topics()->attach($topics);
        
        return redirect()->route('question.show',[$rs->id]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //$question = Question::where('id',$id)->with('topics')->first();
        $question =  $this->questionRepository->byIdWithTopics($id);
        return view('questions.show',compact('question'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
    

}

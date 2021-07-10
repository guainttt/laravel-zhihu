<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAnswerRequest;

use App\Repositories\AnswerRepository;
use Illuminate\Support\Facades\Auth;

class AnswerController extends Controller
{
    protected $answer;
    
    public function __construct(AnswerRepository $answer)
    {
        $this->middleware('auth');
        $this->answer = $answer;
    }
    public function store(StoreAnswerRequest $request,$question)
    {
        // dd($request->all());
        $answer = $this->answer->create([
            'question_id' =>$question,
            'user_id'   =>Auth::id(),
            'body'      =>$request->get('body')
        ]);
        $answer->question()->increment('answers_count');
        return back();
    }
}

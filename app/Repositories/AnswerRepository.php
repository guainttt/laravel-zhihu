<?php
namespace App\Repositories;
use App\Answer;

class  AnswerRepository
{
    public function create(array $attributes)
    {
        return Answer::create($attributes);
    }
    
    public function GetAnswerById($id)
    {
        return Answer::find($id);
    }
}



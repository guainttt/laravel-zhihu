<?php
/**
 * Created by PhpStorm.
 * User: SUN
 * Date: 2021/6/29
 * Time: 17:49
 */
namespace App\Repositories;
use App\Question;
use App\Topic;


class QuestionRepository  
{
    /**
     * 根据question的id查找topic 列表
     * @param $id
     */
    public function byIdWithTopics($id)
    {
        $question = Question::where('id',$id)->with('topics')->first();
        return $question;
    }
    
    public  function  create(array $attributes)
    {
        return Question::create($attributes);
    }
    
    public function normailizeTopic(array $topics)
    {
        //collect 遍历方法
        return collect($topics)->map(function ($topic){
            if(is_numeric($topic)){
                Topic::find($topic)->increment('questions_count');
                return (int)$topic;
            }
            $newTopic = Topic::create(['name'=>$topic,'questions_count'=>1]);
            return $newTopic->id;
        })->toArray();
    }
}
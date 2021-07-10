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
    public function byIdWithTopicsAndAnswers($id)
    {
        $question = Question::where('id',$id)->with('topics','answers')->first();
        return $question;
    }
    
    public  function  create(array $attributes)
    {
        return Question::create($attributes);
    }
    
    /**
     * @param array $topics
     *
     * @return array
     *              
     */
    public function normalizeTopic(array $topics)
    {
        //collect 遍历方法
        return collect($topics)->map(function ($topic){
            //如果是数字
            if(is_numeric($topic)){
                Topic::find($topic)->increment('questions_count');
                return (int)$topic;
            }else{
                 $oldTopic = Topic::where('name','=',$topic)->first();
                 if ($oldTopic){
                     //查得到
                     Topic::find($oldTopic->id)->increment('questions_count');
                     return (int)$oldTopic->id;
                 }else{
                     //查不到
                     $newTopic = Topic::create(['name'=>$topic,'questions_count'=>1]);
                     return $newTopic->id;
                 }
            }
        })->toArray();
    }
    
    
    public function normalize2Topic(array $topics)
    {
        //collect 遍历方法
        return collect($topics)->map(function ($topic){
            if($topic['questions_count']>1){
                //dd($topic['questions_count']);
                $topic = Topic::find($topic['id']);
                $topic->decrement('questions_count');
                return $topic['id'];
            }
            Topic::destroy($topic);
            return $topic['id'];
        });
    }
    
    public function byId($id)
    {
        return Question::find($id);
        
    }
    
    public function getOldTopicList($oldTopics)
    {
        if($oldTopics){
            foreach ( $oldTopics as $v){
                if(is_numeric($v)){
                    $topics[] = $v;
                }else{
                    $oldTopicsList[$v]= $v ;
                }
            }
            if (isset($topics)){
                $oldTopicsList = array_merge(Topic::find($topics)->pluck('name','id')->toArray(),$oldTopicsList);
            }
            
            
        } else{
            $oldTopicsList = [];
        }
        return $oldTopicsList;
    }
    
    /**
     * 问题列表
     */
    public function getQuestionsFeed()
    {
       return Question::published()
         ->latest('updated_at')
         ->with('user')
         ->get();
    }
}
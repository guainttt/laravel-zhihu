<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    //fillable为白名单，表示该字段可被批量赋值；guarded为黑名单，表示该字段不可被批量赋值。
    protected $fillable = ['title','body','user_id'];
    
    public function isHidden()
    {
        return $this->is_hidden === 'T';
    }
    
    public function topics()
    {
        //多对多的关系
        //belongsToMany如果第二个参数不是question_topic的话 可以通过第二个参数传递自定义表名
        return $this->belongsToMany(Topic::class,'question_topic')
          ->withTimestamps();
    }
}

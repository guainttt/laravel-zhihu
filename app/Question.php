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
}

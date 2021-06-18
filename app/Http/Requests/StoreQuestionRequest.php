<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreQuestionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        //是否需要验证
        //return false;
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
          'title'  =>'required|min:6|max:196',
          'body'   =>'required|min:20',
    
        ];
        
    }
    
    public function messages()
    {
        return [
          'body.required'=>'内容不得为空' ,
          'body.min'=>'内容不得少于20个字符' ,
        ];
    }
}

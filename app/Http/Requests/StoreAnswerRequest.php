<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreAnswerRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
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
            //
            'body'=>"required|min:20"
        ];
    }
    
    public function messages()
    {
        return [
          'body.required'=>'回答不得为空' ,
          'body.min'=>'回答不得少于20个字符'
        ];
    }
}

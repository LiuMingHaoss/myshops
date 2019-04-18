<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
class StoreAdsPost extends FormRequest
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
//        dd(request()->input());
        return [
            'a_title' => [
                'required',
                'max:40',
                'min:4',
//                'unique:user',
                'regex:/^[A-Za-z0-9_\x{4e00}-\x{9fa5}]+$/u',
                Rule::unique('ads')->ignore(request()->a_id,'a_id')
            ],
            'a_gjz' => 'required',
            'a_content' => 'required',

        ];
    }
    public function messages(){
        return [
            'a_title.required' => '标题不能为空',
            'a_title.max' => '标题最大40位',
            'a_title.min' => '标题最小4位',
            'a_title.regex' => '标题格式不对',
            'a_gjz.required' => '关键字不能为空',
            'a_content.required'=>'内容不能为空',
        ];
    }
}

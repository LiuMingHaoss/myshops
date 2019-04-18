<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
class StoreYouPost extends FormRequest
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
            'url_name' => [
                'required',
                'regex:/^[A-Za-z0-9_\x{4e00}-\x{9fa5}]+$/u',
                Rule::unique('url')->ignore(request()->u_id,'u_id')
            ],
            'url_url' => [
                'required',
                'regex:/^http:\/\/.+$/',
            ],
        ];
    }
    public function messages(){
        return [
            'url_name.required' => '网站名称不能为空',
            'url_name.regex' => '网站名称格式不对',
            'url_name.unique' => '网站名称已存在',
            'url_url.required' => '网站网址不能为空',
            'url_url.regex'=>'网址格式不对',
        ];
    }
}

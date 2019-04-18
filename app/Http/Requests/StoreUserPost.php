<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
class StoreUserPost extends FormRequest
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
            'user_name' => [
                'required',
                'max:15',
                'min:2',
//                'unique:user',
                'regex:/^[A-Za-z0-9_\x{4e00}-\x{9fa5}]+$/u',
                Rule::unique('user')->ignore(request()->u_id,'u_id')
            ],
            'user_pwd' => 'sometimes|required|max:12|min:6|alpha_dash',
            'user_repwd' => 'sometimes|required|same:user_pwd',
            'user_tel' => 'required',
            'user_email' => 'required|email',
        ];
    }
    public function messages(){
        return [
            'user_name.required' => '用户名称不能为空',
            'user_name.max' => '用户名最大15位',
            'user_name.min' => '用户名最小2位',
            'user_name.unique' => '用户名已存在',
            'user_name.regex'=>'用户名格式不对',
            'user_pwd.required' => '用户密码不能为空',
            'user_pwd.max' => '密码最大12位',
            'user_pwd.min' => '密码最小6位',
            'user_tel.required' => '电话不能为空',
            'user_email.required' => '邮箱不能为空',
            'user_repwd.required' => '确认密码不能为空',
            'user_repwd.same' => '确认密码与密码必须一致',
            'user_email.email' => '邮箱格式不正确',

        ];
    }
}

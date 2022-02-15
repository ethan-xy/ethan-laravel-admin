<?php

namespace Ethan\LaravelAdmin\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AdminUserRequest extends FormRequest
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
        $rules = [
            'name' => 'required|max:255',
        ];

        switch ($this->method()) {
            case 'POST':
                $rules['password'] = 'required|min:8|max:32';
                $rules['email'] = 'required|email|unique:admin_users,email';
                break;
            case 'PATCH':
                $id = $this->route('admin_user');
                $rules['email'] = 'required|email|unique:admin_users,email,' . $id;
                break;
        }

        return $rules;
    }

    public function messages()
    {
        return [
            'name.required' => '请填写名称',
            'email.required' => '请填写email',
            'email.email' => 'email格式错误',
            'email.unique' => 'email已经存在',
            'password.required' => '请填写密码',
            'password.min' => '密码长度必须在8~32位数',
            'password.max' => '密码长度必须在8~32位数',
        ];
    }
}

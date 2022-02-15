<?php

namespace Ethan\LaravelAdmin\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RoleRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [
            'guard_name' => 'required',
        ];

        switch ($this->method()) {
            case 'POST':
                $rules['name'] = ['required', 'regex:/\D+/u', 'unique:roles,name'];
                break;
            case 'PATCH':
                $id = $this->route('role');
                $rules['name'] = ['required', 'regex:/\D+/u', 'unique:roles,name,' . $id];
                break;
        }

        return $rules;
    }


    public function messages()
    {
        return [
            'name.required' => '请添加角色名称',
            'name.regex' => '角色名称不可以是纯数字',
            'name.unique' => '该名称已被占用',
            'guard_name.required' => '请选择归属项目'
        ];
    }
}

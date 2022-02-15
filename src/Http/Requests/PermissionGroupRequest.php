<?php

namespace Ethan\LaravelAdmin\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PermissionGroupRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required',
        ];
    }


    public function messages()
    {
        return [
            'name.required' => '请添加名称',
        ];
    }
}

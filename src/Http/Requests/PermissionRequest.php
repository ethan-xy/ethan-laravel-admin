<?php

namespace Ethan\LaravelAdmin\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PermissionRequest extends FormRequest
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
            'guard_name' => 'required|max:255',
            'display_name' => 'required:max:50',
            'pg_id' => 'required|numeric',
            'sort' => 'numeric'
        ];

        switch ($this->method()) {
            case 'POST':
                break;
            case 'PATCH':
                break;
        }

        return $rules;
    }
}
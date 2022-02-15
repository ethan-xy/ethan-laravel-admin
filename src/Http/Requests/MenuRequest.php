<?php

namespace Ethan\LaravelAdmin\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MenuRequest extends FormRequest
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
            'name' => 'required',
            'guard_name' => 'required',
            'uri' => 'required'
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

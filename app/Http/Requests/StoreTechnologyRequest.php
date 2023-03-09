<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTechnologyRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => ['required', 'unique:types', 'max:50']
        ];
    }
    public function messages()
    {
        return [
            'name.required' => 'Name must be entered',
            'name.unique' => 'A type with this name already exists',
            'name.max' => 'The name cannot exceed :max characters'
        ];
    }
}

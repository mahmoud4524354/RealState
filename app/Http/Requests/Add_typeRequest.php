<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class Add_typeRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'type_name' => 'required|unique:property_types|max:200',
            'type_icon' => 'required'
        ];
    }
}

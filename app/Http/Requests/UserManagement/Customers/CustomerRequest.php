<?php

namespace App\Http\Requests\UserManagement\Customers;

use Illuminate\Foundation\Http\FormRequest;

class CustomerRequest extends FormRequest
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
        $id = $this->route('id');
        return [
            'name' => 'required|string|max:255',
            'phone' => 'required|max:15|unique:users,phone,' . $id,

        ];
    }
    public function messages()
    {
        return [];
    }
}

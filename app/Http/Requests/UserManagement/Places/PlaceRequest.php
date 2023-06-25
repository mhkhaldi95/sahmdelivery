<?php

namespace App\Http\Requests\UserManagement\Places;

use App\Constants\Enum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class PlaceRequest extends FormRequest
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
        $password_validation = $this->route('id') ? 'nullable|min:3|confirmed' : 'required|min:3|confirmed';

        return [
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:50|unique:users,username,' . $id.'|regex:/^[A-Za-z0-9]+$/',
            'phone' => 'required|max:15|unique:users,phone,' . $id,
            'address' => 'nullable|string|max:255',
            'password' => $password_validation,

        ];
    }
    public function messages()
    {
        return [];
    }
}

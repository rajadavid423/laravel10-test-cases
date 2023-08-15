<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class UserApiRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        $user = $this->route('user');
        return match ($this->method()) {
            'POST' => [
                'name' => 'required|string|min:3|max:100',
                'dob' => 'required|date',
                'password' => 'required|string|min:8|max:20',
                'phone' => 'required|numeric|digits_between:3,15',
                'email' => 'required|email|unique:users,email',
            ],
            'PUT' => [
                'name' => 'required|string|min:3|max:100',
                'dob' => 'required|date',
                'password' => 'required|string|min:8|max:20',
                'phone' => 'required|numeric|digits_between:3,15',
                'email' => 'required|email|unique:users,email,'.$user->id,
            ]
        };
    }

    public function failedValidation(\Illuminate\Contracts\Validation\Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'success'   => false,
            'message'   => 'Validation errors',
            'data'      => $validator->errors()
        ], 422));
    }
}

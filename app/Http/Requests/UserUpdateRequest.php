<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserUpdateRequest extends FormRequest
{


    public function authorize(): bool
    {
        return True;
    }


    public function rules(): array
    {

        $userId = $this->route('user')->id; // Retrieve user ID from the route parameters

        return [
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email,' . $userId,
           // 'photo' => 'image|mimes:jpeg,png,jpg,gif',
            'phone' =>'required|integer',
            'password'=>'min:8'
        ];
    }
}

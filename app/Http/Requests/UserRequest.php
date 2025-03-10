<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class UserRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $userId = $this->user ? $this->user->id : null;

        return [
            'name' => 'required|min:3',
            'email' => [
                'required',
                'email',
                Rule::unique('users')->ignore($userId)
            ],
            'password' => 'required|min:8', 
            'profile_picture' => [
                'nullable',
                'image',
                'mimes:jpeg,png,jpg,gif,webp',
                'max:2048',
                'dimensions:max_width=2000,max_height=2000'
            ]
        ];
    }

    public function messages()
    {
        return [
            'profile_picture.image' => 'File harus berupa gambar',
            'profile_picture.mimes' => 'Format gambar harus: jpeg, png, jpg, gif, atau webp',
            'profile_picture.max' => 'Ukuran gambar maksimal 2MB',
            'profile_picture.dimensions' => 'Dimensi gambar maksimal 2000x2000 piksel'
        ];
    }
}
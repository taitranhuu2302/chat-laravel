<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PostRegister extends FormRequest
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
            'email' => 'required|email|unique:users',
            'full_name' => 'required|max:255',
        ];
    }

    public function messages(): array
    {
        return [
            'email.unique' => 'Tài khoản email đã tồn tại',
            'email.required' => 'Vui lòng nhập email',
            'email.email' => 'Email không đúng định dạng',
            'full_name.required' => 'Vui lòng nhập họ tên',
            'full_name.max' => 'Họ tên không được quá 255 ký tự',
        ];
    }
}

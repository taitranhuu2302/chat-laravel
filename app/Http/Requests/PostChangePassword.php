<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PostChangePassword extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'current_password' => 'required|string|min:6',
            'password' => 'required|min:6',
            'password_confirm' => 'required|same:password'
        ];
    }

    public function messages()
    {
        return [
            'current_password.required' => 'Mật khẩu cũ bắt buộc',
            'current_password.string' => 'Mật khẩu cũ phải là kiểu chuỗi',
            'current_password.min' => 'Mật khẩu cũ phải có ít nhất 6 ký tự',
            'password.required' => 'Mật khẩu mới bắt buộc',
            'password.min' => 'Mật khẩu mới phải có ít nhất 6 ký tự',
            'password_confirm.required' => 'Xác nhận mật khẩu bắt buộc',
            'password_confirm.same' => 'Mật khẩu xác nhận không khớp'
        ];
    }
}

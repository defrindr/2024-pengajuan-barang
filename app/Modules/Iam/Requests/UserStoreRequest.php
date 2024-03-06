<?php

namespace App\Modules\Iam\Requests;

use App\Http\Requests\BaseFormRequest;

class UserStoreRequest extends BaseFormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $rules = [
            'username' => 'required|unique:users,username',
            'password' => 'required|min:6',
            'name' => 'required|min:4',
            'email' => 'required|email',
            'role_id' => 'required',
        ];

        return $rules;
    }

    public function attributes()
    {
        return [
            'password' => 'Kata Sandi',
            'username' => 'Nama Pengguna',
            'name' => 'Nama',
            'email' => 'Alamat Surel',
            'role_id' => 'Hak Akses',
        ];
    }

    public function messages()
    {
        return [
            'required' => ':attribute tidak boleh kosong',
            'email' => ':attribute harus email valid',
            'min' => ':attribute setidaknya harus memiliki :min karakter',
        ];
    }
}

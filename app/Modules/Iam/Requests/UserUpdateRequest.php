<?php

namespace App\Modules\Iam\Requests;

use App\Http\Requests\BaseFormRequest;
use App\Models\Iam\User;
use Illuminate\Validation\Rule;

class UserUpdateRequest extends BaseFormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $user = $this->route()->parameter('user');

        $rules = [
            'password' => 'nullable|min:6',
            'name' => 'nullable|min:4',
            'email' => 'nullable|email',
            'role_id' => 'nullable',
        ];

        $rules['username'] = [
            'nullable',
            'string',
            'min:5',
            Rule::unique(User::getTableName())->ignore($user),
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
            'email' => ':attribute harus email valid',
            'min' => ':attribute setidaknya harus memiliki :min karakter',
        ];
    }
}

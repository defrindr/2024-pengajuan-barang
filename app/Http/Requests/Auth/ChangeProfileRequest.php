<?php

namespace App\Http\Requests\Auth;

use App\Http\Requests\BaseFormRequest;

class ChangeProfileRequest extends BaseFormRequest
{
    public function rules(): array
    {
        return [
            'username' => 'required',
            'password' => 'nullable',
            'name' => 'required',
            'email' => 'required',
        ];
    }
}

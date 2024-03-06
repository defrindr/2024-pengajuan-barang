<?php

namespace App\Modules\Iam\Requests;

use App\Http\Requests\BaseFormRequest;

class UserChangeAvatarRequest extends BaseFormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $rules = [];
        $rules['photo'] = 'file|nullable|mimes:jpg,png,gif|max:2048';

        return $rules;
    }

    public function attributes()
    {
        return ['photo' => 'Foto'];
    }

    public function messages()
    {
        return [
            'file' => ':attribute harus berupa file',
            'mimes' => ':attribute mempunyai mime yang tidak valid. harus diantara :mime',
            'max' => ':attribute maksimal berukuran :min',
        ];
    }
}

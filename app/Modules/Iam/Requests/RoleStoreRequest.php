<?php

namespace App\Modules\Iam\Requests;

use App\Http\Requests\BaseFormRequest;

/**
 * Auto-generated RoleStoreRequest
 *
 * @author defrindr
 */
class RoleStoreRequest extends BaseFormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|unique:roles,name',
            'description' => 'required',
        ];
    }

    public function attributes()
    {
        return [
            'name' => 'Nama',
            'description' => 'Deskripsi',
        ];
    }

    public function messages()
    {
        return [
            'required' => ':attribute tidak boleh kosong',
            'unique' => ':attribute dengan nilai yang sama telah terdaftar',
        ];
    }
}

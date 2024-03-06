<?php

namespace App\Modules\Iam\Requests;

use App\Http\Requests\BaseFormRequest;
use App\Models\Iam\Role;
use Illuminate\Validation\Rule;

/**
 * Auto-generated RoleUpdateRequest
 *
 * @author defrindr
 */
class RoleUpdateRequest extends BaseFormRequest
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
        $role = $this->route()->parameter('role');

        $rules = [
            'description' => 'nullable',
        ];

        $rules['name'] = [
            'nullable',
            'string',
            Rule::unique(Role::getTableName())->ignore($role),
        ];

        return $rules;
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
            'unique' => ':attribute dengan nilai yang sama telah terdaftar',
        ];
    }
}

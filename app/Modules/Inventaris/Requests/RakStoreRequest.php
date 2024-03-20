<?php

namespace App\Modules\Inventaris\Requests;

use App\Http\Requests\BaseFormRequest;

/**
 * Auto-generated RakStoreRequest
 *
 * @author defrindr
 */
class RakStoreRequest extends BaseFormRequest
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
            'name' => 'required',
        ];
    }
}

<?php

namespace App\Modules\Inventaris\Requests;

use App\Http\Requests\BaseFormRequest;

/**
 * Auto-generated InventarisStoreRequest
 *
 * @author defrindr
 */
class InventarisStoreRequest extends BaseFormRequest
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
            'category_id' => 'required',
            'rak_id' => 'required',
            'stok' => 'required',
        ];
    }
}

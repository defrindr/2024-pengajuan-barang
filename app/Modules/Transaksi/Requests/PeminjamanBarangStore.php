<?php

namespace App\Modules\Transaksi\Requests;

use App\Http\Requests\BaseFormRequest;

class PeminjamanBarangStore extends BaseFormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'perihal' => 'required',
            'items.*.produk_id' => 'required',
            'items.*.stok' => 'required',
            'items.*.nama_barang' => 'required',
        ];
    }
}

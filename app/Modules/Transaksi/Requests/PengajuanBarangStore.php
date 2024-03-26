<?php

namespace App\Modules\Transaksi\Requests;

use App\Http\Requests\BaseFormRequest;

class PengajuanBarangStore extends BaseFormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'perihal' => 'required',
            'surat_jalan' => 'required',
            'items.*.produk_id' => 'required',
            'items.*.stok' => 'required',
            'items.*.nama_barang' => 'required',
        ];
    }
}

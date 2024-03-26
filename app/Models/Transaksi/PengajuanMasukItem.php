<?php

namespace App\Models\Transaksi;

use App\Models\BaseModel;

class PengajuanMasukItem extends BaseModel
{
    protected $table = 'transaksi_masuk_detail';

    protected $fillable = [
        'transaksi_masuk_id',
        'item_id',
        'nama_barang',
        'stok',
    ];

    protected $hidden = ['created_at', 'updated_at'];
}

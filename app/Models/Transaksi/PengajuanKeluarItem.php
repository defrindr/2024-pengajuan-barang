<?php

namespace App\Models\Transaksi;

use App\Models\BaseModel;

class PengajuanKeluarItem extends BaseModel
{
    protected $table = 'transaksi_keluar_detail';

    protected $fillable = [
        'transaksi_keluar_id',
        'item_id',
        'nama_barang',
        'stok',
    ];

    protected $hidden = ['created_at', 'updated_at'];
}

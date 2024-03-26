<?php

namespace App\Models\Transaksi;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;

class PengajuanKeluar extends BaseModel
{
    use SoftDeletes;

    const STATUS_PENGAJUAN = 'pengajuan';

    const STATUS_DITERIMA = 'diterima';

    const STATUS_DITOLAK = 'ditolak';

    protected $table = 'transaksi_keluar';

    protected $fillable = [
        'pegawai_id',
        'perihal',
        'tanggal',
        'status',
        'approver_id',
    ];

    protected $hidden = ['created_at', 'updated_at', 'deleted_at'];

    public function scopeSearch(Builder $builder, string $keyword): void
    {
        $builder->where('perihal', 'like', "%{$keyword}%");
    }
}

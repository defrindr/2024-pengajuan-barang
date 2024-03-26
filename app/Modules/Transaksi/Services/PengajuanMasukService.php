<?php

namespace App\Modules\Transaksi\Services;

use App\Exceptions\BadRequestHttpException;
use App\Exceptions\ForbiddenHttpException;
use App\Exceptions\NotFoundHttpException;
use App\Http\Controllers\Controller;
use App\Http\Resources\PaginationCollection;
use App\Models\Iam\Role;
use App\Models\Iam\User;
use App\Models\Transaksi\PengajuanMasuk;
use App\Models\Transaksi\PengajuanMasukItem;
use App\Modules\Transaksi\Resources\PengajuanMasukResource;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\DB;

class PengajuanMasukService extends Controller
{
    public static function list($query, int $perPage, string $sort, string $keyword): JsonResource
    {
        $pagination = $query->orderBy(PengajuanMasuk::getTableName().'.id', $sort)
            ->search($keyword)
            ->paginate($perPage);

        return new PaginationCollection($pagination, PengajuanMasukResource::class);
    }

    public static function fetch(int $perPage, string $sort, string $keyword, User $user): JsonResource
    {
        $query = PengajuanMasuk::query();
        if ($user->role_id !== Role::ROLE_ADMIN) {
            $query = $query->where('vendor_id', $user->id);
        }

        return static::list($query, $perPage, $sort, $keyword);
    }

    public static function store(array $payload, User $user)
    {
        DB::beginTransaction();
        $transaction = new PengajuanMasuk([
            'perihal' => $payload['perihal'],
            'surat_jalan' => $payload['surat_jalan'],
            'vendor_id' => $user->id,
            'tanggal' => date('Y-m-d H:i:s'),
            'status' => PengajuanMasuk::STATUS_PENGAJUAN,
        ]);

        if (! $transaction->save()) {
            DB::rollBack();
            throw new BadRequestHttpException('Gagal menyimpan pengajuan masuk');
        }

        $bulk_items = [];
        foreach ($payload['items'] as $item) {
            $bulk_items[] = [
                'transaksi_masuk_id' => $transaction->id,
                'item_id' => $item['produk_id'],
                'nama_barang' => $item['nama_barang'],
                'stok' => $item['stok'],
            ];
        }

        if (! PengajuanMasukItem::insert($bulk_items)) {
            DB::rollBack();
            throw new BadRequestHttpException('Gagal menyimpan item pengajuan masuk');
        }

        DB::commit();

        return true;
    }

    public static function destroy(int $id, User $user)
    {
        $item = static::has($id);

        if ($item->status !== PengajuanMasuk::STATUS_PENGAJUAN) {
            throw new BadRequestHttpException('Tidak dapat menghapus resource dengan status tersebut');
        } elseif ($item->vendor_id !== $user->id) {
            throw new ForbiddenHttpException('Anda tidak mempunyai akses untuk menghapus resource ini');
        }

        DB::beginTransaction();

        PengajuanMasukItem::where('transaksi_masuk_id', '=', $id)->delete();
        PengajuanMasuk::destroy([$id]);

        DB::commit();

        return true;
    }

    public static function has(int $id): PengajuanMasuk
    {
        $resource = PengajuanMasuk::find($id);
        if (! $resource) {
            throw new NotFoundHttpException("Resource #{$id} tidak ditemukan.");
        }

        return $resource;
    }
}

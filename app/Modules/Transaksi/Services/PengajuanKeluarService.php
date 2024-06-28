<?php

namespace App\Modules\Transaksi\Services;

use App\Exceptions\BadRequestHttpException;
use App\Exceptions\ForbiddenHttpException;
use App\Exceptions\NotFoundHttpException;
use App\Http\Controllers\Controller;
use App\Http\Resources\PaginationCollection;
use App\Models\Iam\Role;
use App\Models\Iam\User;
use App\Models\Inventaris\Inventaris;
use App\Models\Transaksi\PengajuanKeluar;
use App\Models\Transaksi\PengajuanKeluarItem;
use App\Modules\Transaksi\Resources\PengajuanKeluarResource;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;

class PengajuanKeluarService extends Controller
{
    public static function list($query, int $perPage, string $sort, string $keyword): JsonResource
    {
        $pagination = $query->orderBy(PengajuanKeluar::getTableName().'.id', $sort)
            ->search($keyword)
            ->paginate($perPage);

        return new PaginationCollection($pagination, PengajuanKeluarResource::class);
    }

    public static function fetch(int $perPage, string $sort, string $keyword, User $user): JsonResource
    {
        $query = PengajuanKeluar::query();
        if ($user->role_id !== Role::ROLE_ADMIN) {
            $query = $query->where('pegawai_id', $user->id);
        }

        return static::list($query, $perPage, $sort, $keyword);
    }

    public static function store(array $payload, User $user)
    {
        DB::beginTransaction();
        $transaction = new PengajuanKeluar([
            'perihal' => $payload['perihal'],
            'pegawai_id' => $user->id,
            'tanggal' => date('Y-m-d H:i:s'),
            'status' => PengajuanKeluar::STATUS_PENGAJUAN,
        ]);

        if (! $transaction->save()) {
            DB::rollBack();
            throw new BadRequestHttpException('Gagal menyimpan pengajuan masuk');
        }

        $bulk_items = [];
        foreach ($payload['items'] as $item) {
            $bulk_items[] = [
                'transaksi_keluar_id' => $transaction->id,
                'item_id' => $item['produk_id'],
                'nama_barang' => $item['nama_barang'],
                'stok' => $item['stok'],
            ];
        }

        if (! PengajuanKeluarItem::insert($bulk_items)) {
            DB::rollBack();
            throw new BadRequestHttpException('Gagal menyimpan item pengajuan masuk');
        }

        DB::commit();

        return true;
    }

    public static function destroy(int $id, User $user)
    {
        $item = static::has($id);

        if ($item->status !== PengajuanKeluar::STATUS_PENGAJUAN) {
            throw new BadRequestHttpException('Tidak dapat menghapus resource dengan status tersebut');
        } elseif ($item->pegawai_id !== $user->id) {
            throw new ForbiddenHttpException('Anda tidak mempunyai akses untuk menghapus resource ini');
        }

        DB::beginTransaction();

        PengajuanKeluarItem::where('transaksi_keluar_id', '=', $id)->delete();
        PengajuanKeluar::destroy([$id]);

        DB::commit();

        return true;
    }

    public static function acc(int $id, User $user)
    {
        $model = static::has($id);
        if ($model->status !== PengajuanKeluar::STATUS_PENGAJUAN) {
            throw new BadRequestHttpException('Tidak dapat menghapus resource dengan status tersebut');
        } elseif ($user->id !== Role::ROLE_ADMIN) {
            throw new ForbiddenHttpException('Anda tidak mempunyai akses untuk menyetujui resource ini');
        }

        DB::beginTransaction();

        $items = $model->items;

        foreach ($items as $item) {
            $product = Inventaris::where('id', $item->item_id)->first();

            $product->stok_sekarang -= $item->stok;

            if ($product->stok_sekarang < 0) {
                throw new BadRequestException('Produk #'.$product->name.' stok tidak cukup');
            }

            $product->save();
        }

        $model->status = PengajuanKeluar::STATUS_DITERIMA;
        $model->update();

        DB::commit();

        return true;
    }

    public static function back(int $id)
    {
        $model = static::has($id);
        if ($model->status !== PengajuanKeluar::STATUS_DITERIMA) {
            throw new BadRequestHttpException('Tidak dapat menghapus resource dengan status tersebut');
        }

        DB::beginTransaction();

        $items = $model->items;

        foreach ($items as $item) {
            $product = Inventaris::where('id', $item->item_id)->first();

            $product->stok_sekarang += $item->stok;

            $product->save();
        }

        $model->status = PengajuanKeluar::STATUS_DIKEMBALIKAN;
        $model->update();

        DB::commit();

        return true;
    }

    public static function reject(int $id, User $user)
    {
        $item = static::has($id);

        if ($item->status !== PengajuanKeluar::STATUS_PENGAJUAN) {
            throw new BadRequestHttpException('Tidak dapat menghapus resource dengan status tersebut');
        } elseif ($user->id !== Role::ROLE_ADMIN) {
            throw new ForbiddenHttpException('Anda tidak mempunyai akses untuk menolak resource ini');
        }

        DB::beginTransaction();
        $item->status = PengajuanKeluar::STATUS_DITOLAK;
        $item->update();

        DB::commit();

        return true;
    }

    public static function has(int $id): PengajuanKeluar
    {
        $resource = PengajuanKeluar::find($id);
        if (! $resource) {
            throw new NotFoundHttpException("Resource #{$id} tidak ditemukan.");
        }

        return $resource;
    }
}

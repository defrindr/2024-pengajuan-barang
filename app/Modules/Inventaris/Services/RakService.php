<?php

namespace App\Modules\Inventaris\Services;

use App\Exceptions\NotFoundHttpException;
use App\Http\Resources\PaginationCollection;
use App\Models\Inventaris\Rak;
use App\Modules\Inventaris\Resources\RakResource;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\DB;

/**
 * Kelas untuk handling bisnis proses
 * auto-generated RakService
 *
 * @author defrindr
 */
class RakService
{
    /**
     * Mengambil paginasi data dari resources
     */
    public static function list(int $perPage, string $sort, string $keyword): JsonResource
    {
        $pagination = Rak::orderBy('name', $sort)
            ->search($keyword)
            ->paginate($perPage);

        return new PaginationCollection($pagination, RakResource::class);
    }

    /**
     * Mendapatkan resource by id
     */
    public static function getById(int $id): JsonResource
    {
        $resource = self::has($id);

        return new RakResource($resource);
    }

    /**
     * Menyimpan payload ke database
     */
    public static function store(array $payload): bool
    {
        return Rak::create($payload) ? true : false;
    }

    /**
     * Menyimpan perubahan payload ke database sesuai dengan resource yang dipilih
     */
    public static function update(int $id, array $payload): bool
    {
        $resource = self::has($id);
        $payload = array_filter($payload, 'strlen');

        return $resource->update($payload) ? true : false;
    }

    /**
     * Menghapus aksi dari database
     */
    public static function destroy(int $id): bool
    {
        $resource = self::has($id);

        DB::beginTransaction();

        $deleted = 1;

        $products = $resource->inventaris;
        foreach ($products as $product) $deleted = $deleted && $product->delete();

        $deleted = $deleted && $resource->delete();

        if ($deleted) DB::commit();
        else DB::rollBack();

        return $deleted;
    }

    public static function has(int $id): Rak
    {
        $resource = Rak::find($id);
        if (! $resource) {
            throw new NotFoundHttpException("Resource #{$id} tidak ditemukan.");
        }

        return $resource;
    }
}

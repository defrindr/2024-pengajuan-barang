<?php

namespace App\Modules\Inventaris\Services;

use App\Exceptions\NotFoundHttpException;
use App\Http\Resources\PaginationCollection;
use App\Models\Inventaris\Kategori;
use App\Modules\Inventaris\Resources\KategoriResource;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Kelas untuk handling bisnis proses
 * auto-generated KategoriService
 *
 * @author defrindr
 */
class KategoriService
{
    /**
     * Mengambil paginasi data dari resources
     */
    public static function list(int $perPage, string $sort): JsonResource
    {
        $pagination = Kategori::orderBy('id', $sort)
            ->paginate($perPage);

        return new PaginationCollection($pagination, KategoriResource::class);
    }

    /**
     * Mendapatkan resource by id
     */
    public static function getById(int $id): JsonResource
    {
        $resource = self::has($id);

        return new KategoriResource($resource);
    }

    /**
     * Menyimpan payload ke database
     */
    public static function store(array $payload): bool
    {
        return Kategori::create($payload) ? true : false;
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

        return $resource->delete();
    }

    public static function has(int $id): Kategori
    {
        $resource = Kategori::find($id);
        if (! $resource) {
            throw new NotFoundHttpException("Resource #{$id} tidak ditemukan.");
        }

        return $resource;
    }
}

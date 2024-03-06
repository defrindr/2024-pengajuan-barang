<?php

namespace App\Modules\Iam\Services;

use App\Exceptions\NotFoundHttpException;
use App\Http\Resources\PaginationCollection;
use App\Models\Iam\Role;
use App\Modules\Iam\Resources\RoleResource;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Kelas untuk handling bisnis proses
 * auto-generated RoleService
 *
 * @author defrindr
 */
class RoleService
{
    /**
     * Mengambil paginasi data dari model
     */
    public static function list(int $perPage, string $sort): JsonResource
    {
        $pagination = Role::orderBy('id', $sort)
            ->paginate($perPage);

        return new PaginationCollection($pagination, RoleResource::class);
    }

    /**
     * Mendapatkan resource by id
     */
    public static function getById(int $id): JsonResource
    {
        $resource = self::has($id);

        return new RoleResource($resource);
    }

    /**
     * Menyimpan payload ke database
     */
    public static function store(array $payload): bool
    {
        return Role::create($payload) ? true : false;
    }

    /**
     * Menyimpan perubahan payload ke database sesuai dengan model yang dipilih
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

    public static function has(int $id): Role
    {
        $resource = Role::find($id);
        if (! $resource) {
            throw new NotFoundHttpException("Model #{$id} tidak ditemukan.");
        }

        return $resource;
    }
}

<?php

namespace App\Modules\Inventaris\Services;

use App\Exceptions\NotFoundHttpException;
use App\Http\Resources\PaginationCollection;
use App\Models\Inventaris\Inventaris;
use App\Modules\Inventaris\Resources\InventarisResource;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Log;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

/**
 * Kelas untuk handling bisnis proses
 * auto-generated InventarisService
 *
 * @author defrindr
 */
class InventarisService
{
    /**
     * Mengambil paginasi data dari resources
     */
    public static function list(int $perPage, string $sort, string $keyword): JsonResource
    {
        $pagination = Inventaris::orderBy(Inventaris::getTableName().'.id', $sort)
            ->search($keyword)
            ->paginate($perPage);

        return new PaginationCollection($pagination, InventarisResource::class);
    }

    /**
     * Mendapatkan resource by id
     */
    public static function getById(int $id): JsonResource
    {
        $resource = self::has($id);

        return new InventarisResource($resource);
    }

    /**
     * Menghapus aksi dari database
     */
    public static function destroy(int $id): bool
    {
        $resource = self::has($id);

        return $resource->delete();
    }

    public static function has(int $id): Inventaris
    {
        $resource = Inventaris::find($id);
        if (! $resource) {
            throw new NotFoundHttpException("Resource #{$id} tidak ditemukan.");
        }

        return $resource;
    }

    public static function qrcodeFrom($id): mixed
    {
        try {
            $resource = static::has($id);
            $image = QrCode::format('png')
                ->size(200)
                ->style('dot')
                ->eye('circle')->margin(1)->generate($resource->qrcode);

            return response($image)
                ->header('Content-type', 'image/png');
        } catch (\Throwable $th) {
            Log::error($th->getMessage());

            return null;
        }
    }
}

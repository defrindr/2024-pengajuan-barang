<?php

namespace App\Modules\Inventaris\Controllers;

use App\Helpers\PaginationHelper;
use App\Helpers\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\InventarisModifyStockRequest;
use App\Modules\Inventaris\Requests\InventarisStoreRequest;
use App\Modules\Inventaris\Requests\InventarisUpdateRequest;
use App\Modules\Inventaris\Services\InventarisService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

/**
 * Auto-generated InventarisController
 *
 * @author defrindr
 */
class InventarisController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $perPage = PaginationHelper::perPage($request);
        $sort = PaginationHelper::sortCondition($request, PaginationHelper::SORT_DESC);
        $keyword = $request->get('search') ?? '';

        return ResponseHelper::successWithData(InventarisService::list($perPage, $sort, $keyword));
    }

    public function store(InventarisStoreRequest $request): JsonResponse
    {
        try {
            $success = InventarisService::store($request->validated());

            if ($success) {
                return ResponseHelper::successWithData(null, 'Resource berhasil dibuat', 201);
            } else {
                return ResponseHelper::badRequest('Resource gagal dibuat');
            }
        } catch (\Throwable $th) {
            Log::error($th->getMessage());

            return ResponseHelper::error($th, 'Terjadi kesalahan saat menjalankan aksi');
        }
    }

    public function update(InventarisUpdateRequest $request, int $id): JsonResponse
    {
        try {
            $success = InventarisService::update($id, $request->validated());

            if ($success) {
                return ResponseHelper::successWithData(null, 'Resource berhasil diubah');
            } else {
                return ResponseHelper::badRequest('Resource gagal diubah');
            }
        } catch (\Throwable $th) {
            Log::error($th->getMessage());

            return ResponseHelper::error($th, 'Terjadi kesalahan saat menjalankan aksi');
        }
    }

    public function options()
    {
        return ResponseHelper::successWithData(InventarisService::options(), 'Resource berhasil diubah');
    }

    public function notEmptyStock(Request $request): JsonResponse
    {
        $perPage = PaginationHelper::perPage($request);
        $sort = PaginationHelper::sortCondition($request, PaginationHelper::SORT_DESC);
        $keyword = $request->get('search') ?? '';

        return ResponseHelper::successWithData(InventarisService::notEmptyStock($perPage, $sort, $keyword));
    }

    public function getByQrcode(string $qrcode): JsonResponse
    {
        try {
            return ResponseHelper::successWithData(InventarisService::getByQrcode($qrcode));
        } catch (\Throwable $th) {
            Log::error($th->getMessage());

            return ResponseHelper::error($th, 'Terjadi kesalahan saat menjalankan aksi');
        }
    }

    public function show(int $id): JsonResponse
    {
        try {
            return ResponseHelper::successWithData(InventarisService::getById($id));
        } catch (\Throwable $th) {
            Log::error($th->getMessage());

            return ResponseHelper::error($th, 'Terjadi kesalahan saat menjalankan aksi');
        }
    }

    public function destroy(int $id): JsonResponse
    {
        try {
            $success = InventarisService::destroy($id);

            if ($success) {
                return ResponseHelper::successWithData(null, 'Resource berhasil dihapus');
            } else {
                return ResponseHelper::badRequest('Resource gagal dihapus');
            }
        } catch (\Throwable $th) {
            Log::error($th->getMessage());

            return ResponseHelper::error($th, 'Terjadi kesalahan saat menjalankan aksi');
        }
    }

    public function qrcode(int $id)
    {
        try {
            return InventarisService::qrcodeFrom($id);
        } catch (\Throwable $th) {
            Log::error($th->getMessage());

            return ResponseHelper::error($th, 'Terjadi kesalahan saat menjalankan aksi');
        }
    }

    public function modifyStock(int $id, InventarisModifyStockRequest $request)
    {
        try {
            $success = InventarisService::modifyStock($id, $request->validated());
            if ($success) {
                return ResponseHelper::successWithData(null, 'Stok berhasil di modifikasi');
            } else {
                return ResponseHelper::badRequest('Stok gagal di modifikasi');
            }
        } catch (\Throwable $th) {
            Log::error($th->getMessage());

            return ResponseHelper::error($th, 'Terjadi kesalahan saat menjalankan aksi');
        }
    }
}

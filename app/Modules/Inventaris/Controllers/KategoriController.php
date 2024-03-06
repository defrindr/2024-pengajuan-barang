<?php

namespace App\Modules\Inventaris\Controllers;

use App\Helpers\PaginationHelper;
use App\Helpers\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Modules\Inventaris\Requests\KategoriStoreRequest;
use App\Modules\Inventaris\Requests\KategoriUpdateRequest;
use App\Modules\Inventaris\Services\KategoriService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

/**
 * Auto-generated KategoriController
 *
 * @author defrindr
 */
class KategoriController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $perPage = PaginationHelper::perPage($request);
        $sort = PaginationHelper::sortCondition($request, PaginationHelper::SORT_DESC);
        $keyword = $request->get('search') ?? '';

        return ResponseHelper::successWithData(KategoriService::list($perPage, $sort, $keyword));
    }

    public function show(int $id): JsonResponse
    {
        try {
            return ResponseHelper::successWithData(KategoriService::getById($id));
        } catch (\Throwable $th) {
            Log::error($th->getMessage());

            return ResponseHelper::error($th, 'Terjadi kesalahan saat menjalankan aksi');
        }
    }

    public function store(KategoriStoreRequest $request): JsonResponse
    {
        try {
            $success = KategoriService::store($request->validated());

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

    public function update(KategoriUpdateRequest $request, int $id): JsonResponse
    {
        try {
            $success = KategoriService::update($id, $request->validated());

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

    public function destroy(int $id): JsonResponse
    {
        try {
            $success = KategoriService::destroy($id);

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
}

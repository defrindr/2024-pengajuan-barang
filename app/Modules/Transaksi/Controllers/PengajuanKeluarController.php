<?php

namespace App\Modules\Transaksi\Controllers;

use App\Helpers\PaginationHelper;
use App\Helpers\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Modules\Transaksi\Requests\PeminjamanBarangStore;
use App\Modules\Transaksi\Services\PengajuanKeluarService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PengajuanKeluarController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $user = auth()->user();
        $perPage = PaginationHelper::perPage($request);
        $sort = PaginationHelper::sortCondition($request, PaginationHelper::SORT_DESC);
        $keyword = $request->get('search') ?? '';

        return ResponseHelper::successWithData(PengajuanKeluarService::fetch($perPage, $sort, $keyword, $user));
    }

    public function store(PeminjamanBarangStore $request): JsonResponse
    {
        $user = auth()->user();

        try {
            $success = PengajuanKeluarService::store($request->validated(), $user);

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

    public function destroy(int $id): JsonResponse
    {
        $user = auth()->user();
        try {
            $success = PengajuanKeluarService::destroy($id, $user);

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

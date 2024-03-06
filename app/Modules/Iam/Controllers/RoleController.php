<?php

namespace App\Modules\Iam\Controllers;

use App\Helpers\PaginationHelper;
use App\Helpers\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Modules\Iam\Requests\RoleAssignActionRequest;
use App\Modules\Iam\Requests\RoleAssignMenuRequest;
use App\Modules\Iam\Requests\RoleStoreRequest;
use App\Modules\Iam\Requests\RoleUpdateRequest;
use App\Modules\Iam\Services\RoleService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

/**
 * Auto-generated RoleController
 *
 * @author defrindr
 */
class RoleController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $perPage = PaginationHelper::perPage($request);
        $sort = PaginationHelper::sortCondition($request, PaginationHelper::SORT_DESC);

        return ResponseHelper::successWithData(RoleService::list($perPage, $sort));
    }

    public function show(int $id): JsonResponse
    {
        return ResponseHelper::successWithData(RoleService::getById($id));
    }

    public function store(RoleStoreRequest $request): JsonResponse
    {
        try {
            $success = RoleService::store($request->validated());

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

    public function update(RoleUpdateRequest $request, int $id): JsonResponse
    {
        try {
            $success = RoleService::update($id, $request->validated());

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

    public function assignAction(RoleAssignActionRequest $request, int $id): JsonResponse
    {
        try {
            $success = RoleService::assignAction($id, $request->validated());

            if ($success['status']) {
                return ResponseHelper::successWithData(null, $success['created'] ? 'Aksi berhasil ditetapkan' : 'Aksi berhasil dihapus dari role');
            } else {
                return ResponseHelper::badRequest('Aksi gagal ditetapkan');
            }
        } catch (\Throwable $th) {
            Log::error($th->getMessage());

            return ResponseHelper::error($th, 'Terjadi kesalahan saat menjalankan aksi');
        }
    }

    public function assignMenu(RoleAssignMenuRequest $request, int $id): JsonResponse
    {
        try {
            $success = RoleService::assignMenu($id, $request->validated());

            if ($success['status']) {
                return ResponseHelper::successWithData(null, $success['created'] ? 'Menu berhasil ditetapkan' : 'Menu berhasil dihapus dari role');
            } else {
                return ResponseHelper::badRequest('Menu gagal ditetapkan');
            }
        } catch (\Throwable $th) {
            Log::error($th->getMessage());

            return ResponseHelper::error($th, 'Terjadi kesalahan saat menjalankan Menu');
        }
    }

    public function destroy(int $id): JsonResponse
    {
        try {
            $success = RoleService::destroy($id);

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

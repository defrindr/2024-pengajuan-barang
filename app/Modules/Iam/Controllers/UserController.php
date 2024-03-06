<?php

namespace App\Modules\Iam\Controllers;

use App\Helpers\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Models\Iam\User;
use App\Modules\Iam\Requests\UserChangeAvatarRequest;
use App\Modules\Iam\Requests\UserStoreRequest;
use App\Modules\Iam\Requests\UserUpdateRequest;
use App\Modules\Iam\Services\UserService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    /**
     * Mendapatkan data seluruh pengguna
     */
    public function index(Request $request): JsonResponse
    {
        return ResponseHelper::successWithData(UserService::paginate($request));
    }

    /**
     * Mendapatkan pengguna dengan berdasarkan {id}
     */
    public function show(int $userId): JsonResponse
    {
        try {
            return ResponseHelper::successWithData(UserService::getById($userId), 'Pengguna ditemukan');
        } catch (\Throwable $th) {
            Log::error($th->getMessage());

            return ResponseHelper::error($th, 'Terjadi kesalahan saat menjalankan aksi');
        }
    }

    /**
     * Menambahkan user baru ke aplikasi
     *
     * @param  Request  $request
     */
    public function store(UserStoreRequest $request): JsonResponse
    {
        // simpan ke database
        try {
            $success = UserService::create($request->validated(), $request->file('photo'));

            if ($success) {
                return ResponseHelper::successWithData(null, 'User berhasil dibuat', 201);
            } else {
                return ResponseHelper::badRequest(null, 'Gagal menambahkan data !');
            }
        } catch (\Throwable $th) {
            Log::error($th->getMessage());

            return ResponseHelper::error($th, 'Terjadi kesalahan saat menjalankan aksi');
        }
    }

    /**
     * Mengubah data pengguna dengan berdasarkan {id}
     *
     * @param  Request  $request
     */
    public function update(UserUpdateRequest $request, int $userId): JsonResponse
    {
        // simpan ke database
        try {
            $success = UserService::update($userId, $request->validated());

            if ($success) {
                return ResponseHelper::successWithData(null, 'User berhasil diubah');
            }

            return ResponseHelper::badRequest(null, 'Gagal mengubah data !');
        } catch (\Throwable $th) {
            Log::error($th->getMessage());

            return ResponseHelper::error($th, 'Terjadi kesalahan saat menjalankan aksi');
        }
    }

    /**
     * Mengubah avatar pengguna dengan berdasarkan {id}
     *
     * @param  Request  $request
     */
    public function changeAvatar(UserChangeAvatarRequest $request, int $userId): JsonResponse
    {
        // simpan ke database
        try {
            $success = UserService::changeAvatar($userId, $request->file('photo'));

            if ($success) {
                return ResponseHelper::successWithData(null, 'Avatar berhasil diubah');
            }

            return ResponseHelper::badRequest(null, 'Gagal mengubah avatar !');
        } catch (\Throwable $th) {
            Log::error($th->getMessage());

            return ResponseHelper::error($th, 'Terjadi kesalahan saat menjalankan aksi');
        }
    }

    /**
     * Menghapus data user berdasarkan dengan {id}
     */
    public function destroy(User $user): JsonResponse
    {
        try {
            $user->delete();

            return ResponseHelper::successWithData(null, 'User berhasil dihapus');
        } catch (\Throwable $th) {
            Log::error($th->getMessage());

            return ResponseHelper::error($th, 'Terjadi kesalahan saat menjalankan aksi');
        }
    }
}

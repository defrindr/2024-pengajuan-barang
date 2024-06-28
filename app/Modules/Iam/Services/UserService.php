<?php

namespace App\Modules\Iam\Services;

use App\Exceptions\NotFoundHttpException;
use App\Helpers\PaginationHelper;
use App\Helpers\RequestHelper;
use App\Http\Resources\PaginationCollection;
use App\Models\Iam\Role;
use App\Models\Iam\User;
use App\Modules\Iam\Resources\UserResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class UserService
{
    /**
     * Fungsi untuk melakukan paginasi dan filter list data
     */
    public static function paginate(Request $request): ResourceCollection
    {
        // prepare parameter query
        $keyword = $request->get('search');
        $perPage = PaginationHelper::perPage($request);
        $sort = PaginationHelper::sortCondition($request, PaginationHelper::SORT_DESC);

        // query database
        $pagination = User::orderBy('id', $sort)
            ->search($keyword)
            ->paginate($perPage);

        // collect pagination
        return new PaginationCollection($pagination, UserResource::class);
    }

    public static function options()
    {
        return [
            'roles' => Role::select('id', 'name')->get(),
        ];
    }

    /**
     * Fungsi untuk menambahkan data baru
     */
    public static function create(array $payload): bool
    {
        // convert password ke hash
        $payload['password'] = Hash::make($payload['password']);
        $payload['photo'] = User::DEFAULT_AVATAR;

        // simpan ke database
        return User::create($payload) ? true : false;
    }

    /**
     * Fungsi untuk mengubah data
     */
    public static function update(int $userId, array $payload): bool
    {
        $user = self::has($userId);
        $payload = array_filter($payload, 'strlen');

        // jika terdapat password, maka convert ke hash
        if (isset($payload['password'])) {
            $payload['password'] = Hash::make($payload['password']);
        } else {
            $payload['password'] = $user->password;
        }

        // update user di database
        return $user->update($payload);
    }

    /**
     * Fungsi untuk mengubah avatar
     */
    public static function changeAvatar(int $userId, ?UploadedFile $photo): bool
    {
        $user = self::has($userId);

        $payload = [];

        // simpan foto ke storage
        if ($photo) {
            $responseUpload = RequestHelper::uploadImage($photo, User::getRelativeAvatarPath(), $user->photo !== User::DEFAULT_AVATAR ? $user->photo : null);
            if (! $responseUpload['success']) {
                throw new BadRequestHttpException('Gambar gagal diunggah');
            }
            $payload['photo'] = $responseUpload['fileName'];
        } else {
            // jika gambar tidak ada, maka reset ke default
            $payload['photo'] = User::DEFAULT_AVATAR;
        }

        // update database
        return $user->update($payload);
    }

    /**
     * Mencari user berdasarkan userId
     */
    public static function has(int $userId): User
    {
        $resource = User::find($userId);
        if (! $resource) {
            throw new NotFoundHttpException("Resource #{$userId} tidak ditemukan.");
        }

        return $resource;
    }

    /**
     * Mendapatkan user resource berdasarkan userId
     */
    public static function getById(int $userId)
    {
        $resource = self::has($userId);

        return new UserResource($resource);
    }
}

<?php

namespace App\Modules\Iam\Resources;

use App\Helpers\ArrayHelper;
use App\Models\Iam\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $resource = parent::toArray($request);

        // change snakecase to camelcase
        $resource = ArrayHelper::replaceKey($resource, [
            'email_verified_at' => 'emailVerifiedAt',
            'role_id' => 'roleId',
        ]);

        $resource['photo'] = asset_storage(User::getRelativeAvatarPath().$this->photo);
        $resource['role'] = new RoleResource($this->role);

        return $resource;
    }
}

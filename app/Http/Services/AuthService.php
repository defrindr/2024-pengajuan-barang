<?php

namespace App\Http\Services;

use App\Models\Iam\User;

class AuthService
{
  public static function changeProfile(array $payload, User $user)
  {
    // $user->username = $payload['username'];
    $user->name = $payload['name'];
    $user->email = $payload['email'];

    if (!empty($payload['password'])) {
      $user->password_hash = bcrypt($payload['password']);
    }

    return $user->update() ? $user : false;
  }
}

<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseHelper;

class MainController extends Controller
{
    public static function dashboard()
    {
        return ResponseHelper::success([
            'name' => config('app.name'),
            'author' => config('app.author'),
            'version' => floatval(config('app.version')),
        ]);
    }
}

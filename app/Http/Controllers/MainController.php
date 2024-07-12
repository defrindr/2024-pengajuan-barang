<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseHelper;
use App\Models\Iam\Role;
use App\Models\Iam\User;
use App\Models\Inventaris\Inventaris;
use App\Models\Inventaris\Kategori;
use App\Models\Inventaris\Rak;
use App\Models\Transaksi\PengajuanKeluar;
use App\Models\Transaksi\PengajuanMasuk;

class MainController extends Controller
{
    public static function dashboard()
    {
        $user = auth()->user();
        $roleId = intval($user->role_id);

        $items = [];
        if ($roleId === Role::ROLE_ADMIN) {
            $items[] = [
                'count' => Kategori::count(),
                'title' => 'Kategori',
                'to' => 'app.kategori.list',
                'icon' => 'inbox',
            ];
            $items[] = [
                'count' => Rak::count(),
                'title' => 'RAK',
                'to' => 'app.rak.list',
                'icon' => 'server',
            ];
            $items[] = [
                'count' => Inventaris::count(),
                'title' => 'Inventaris',
                'to' => 'app.inventaris.list',
                'icon' => 'database',
            ];
            $items[] = [
                'count' => User::count(),
                'title' => 'Pengguna',
                'to' => 'app.user.list',
                'icon' => 'users',
            ];
        }

        if (in_array($roleId, [Role::ROLE_ADMIN, Role::ROLE_EMPLOYEE])) {
            $totalData = PengajuanKeluar::count();

            if ($roleId == Role::ROLE_EMPLOYEE) {
                $totalData = PengajuanKeluar::where('pegawai_id', $user->id)->count();
            }

            $items[] = [
                'count' => $totalData,
                'title' => 'Peminjaman',
                'to' => 'app.peminjaman.list',
                'icon' => 'rotate-left',
            ];
        }

        if (in_array($roleId, [Role::ROLE_ADMIN, Role::ROLE_VENDOR])) {
            $totalData = PengajuanMasuk::count();
            if ($roleId == Role::ROLE_EMPLOYEE) {
                $totalData = PengajuanMasuk::where('vendor_id', $user->id)->count();
            }

            $items[] = [
                'count' => $totalData,
                'title' => 'Pengajuan',
                'to' => 'app.pengajuan-masuk.list',
                'icon' => 'share',
            ];
        }

        return ResponseHelper::successWithData($items);
    }
}

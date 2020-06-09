<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ScanController extends Controller
{

    // ----------------- ЗАГРУЗКА ШАБЛОНА ----------------------------------//
    public function index(Request $request)
    {
        $role = session('role_id');
        $users = session('user_name');

        return view('ScanPhotoPage.scan_photo',
            [
                'title' => 'Сканирование фотографий',
                'role' => $role,
                'username' => $users

            ]);
    }

}

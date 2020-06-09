<?php

namespace App\Http\Controllers\Reting;

use App\Http\Controllers\Controller;

class RetingController extends Controller
{

    public function index()
    {
        $role = session('role_id');
        $users = session('user_name');


        return view('ReitingPage.reting_phone',
            [
                'title' => 'Рейтинг с телефонами',
                'role' => $role,
                'username' => $users
            ]);
    }
}

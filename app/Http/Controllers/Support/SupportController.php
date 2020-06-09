<?php

namespace App\Http\Controllers\Support;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SupportController extends Controller
{

    public function index(Request $request)
    {
        $role = session('role_id');
        $users = session('user_name');
        return view('SupportPage.Support',
            [
                'title' => 'Тех.поддержка',
                'role' => $role,
                'username' => $users
            ]);
    }
}

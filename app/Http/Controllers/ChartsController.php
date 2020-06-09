<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class ChartsController extends Controller
{

    public function logout()
    {
        session()->flush();
        return redirect('/');
    }

    public function index()
    {
        $role = session('role_id');
        $users = session('user_name');


        return view('ChartsPage.Charts',
            [
                'title' => 'Графики',
                'role' => $role,
                'username' => $users
            ]);
    }
}

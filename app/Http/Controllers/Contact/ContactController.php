<?php

namespace App\Http\Controllers\Contact;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ContactController extends Controller
{

    public function index(Request $request)
    {
        $role = session('role_id');
        $users = session('user_name');
        return view('ContactPage.Contact',
            [
                'title' => 'Контакты',
                'role' => $role,
                'username' => $users
            ]);
    }
}

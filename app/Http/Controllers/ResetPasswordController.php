<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

class ResetPasswordController extends Controller
{

    public function __construct()
    {
    }
    public function index()
    {
        return view('Reset-PasswordPage.reset-password',['title' => 'Восстановление пароля']);
    }
}

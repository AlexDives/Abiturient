<?php

namespace App\Http\Controllers\Reports;

use App\Http\Controllers\Controller;

class Report_SpesialController extends Controller
{

    public function index()
    {
        $role = session('role_id');
        $users = session('user_name');


        return view('ReportPages.Report_Special',
            [
                'title' => 'Количество заявлений по специальности',
                'role' => $role,
                'username' => $users
            ]);
    }
}

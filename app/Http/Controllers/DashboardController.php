<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Persons;

class DashboardController extends Controller
{
// ----------------- Событие разрывание сессии  ----------------------------------//
    public function logout()
    {
        session()->flush();
        return redirect('/');
    }

    // ----------------- ЗАГРУЗКА ШАБЛОНА ----------------------------------//
    public function index(Request $request)
    {
            $role = session('role_id');
            $users = session('user_name');

            return view('DashboardPage.dashboard',
                [
                    'title' => 'Главное',
                    'role' => $role,
                    'username' => $users

                ]);
    }
    // ------------ ЗАГРУЗКА ТАБЛИЦЫ АБИТУРИЕНТОВ ------------------------//
    public function loadTable()
    {
        $arr = Persons::DashboardTable();
        header("Content-type: application/json; charset=utf-8");
        return json_encode($arr, true);
    }

    public function loadSidebar(Request $request){
      $query = Persons::DashboardSidebar($request->idPersons);
      $arr = [
        "FirstName" => $query->FirstName,
        "Name" => $query->Name,
        "LastName" => $query->LastName,
        "Avatar" => $query->Avatar,
        "Birthday" => date("d.m.Y", strtotime($query->Birthday))
      ];
      header("Content-type: application/json; charset=utf-8");

      return json_encode($arr, true);
    }
    public function ShifrT(Request $request){
      $arr = Persons::DashboardPersonsStatment($request->idPersons);
      header("Content-type: application/json; charset=utf-8");
      return json_encode($arr, true);
    }
}

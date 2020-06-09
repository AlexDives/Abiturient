<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
        $item_abit = DB::table('persons')
             //->join('abit_statements', 'persons.id', '=', 'abit_statements.person_id')
            // ->join('abit_examCard', 'state_id', '=', 'abit_statements.id')
            //->leftJoin('persPrivilege', 'person.id', '=', 'persPrivilege.id_pers')
            ->select
            (
                'persons.id as id_Abit',
                'persons.famil as FirstName',
                'persons.name as Name',
                'persons.otch as LastName'

            )->get();
        $k = [];
        $i = 0;
        foreach ($item_abit as $key) {

            $k +=[$i =>[$key->id_Abit, $key->FirstName.' '.$key->Name.' '.$key->LastName,'нет','нахер','дебилов','баранов','ссыт']];
            $i++;
        }
        $arr=array
        (
            "data" =>
               $k
        );
        header("Content-type: application/json; charset=utf-8");
        return json_encode($arr, true);
    }
}

<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{

    public function check()
    {
        if (session()->has('user_id'))
        {
            return redirect('/dashboard');
        }
        else
        {
            return view('LoginPage.welcome',['title' => 'Авторизация']);
        }
    }
    public function login(Request $request)
    {
        $user = DB::table('users')
            ->leftJoin('user_roles', 'user_roles.user_id', '=', 'users.id')
            ->leftJoin('roles', 'roles.id', '=', 'user_roles.role_id')
            ->select('roles.name as role_name','users.*', 'user_roles.abit_branch_id')
            ->where(
                ['users.login' => $request->email]
            )
            ->first();
        if ($user != null)
        {
            //-----------Если роль id = 1 ------------------------//
            if (Hash::check($request->password , $user->password))
            {
                DB::table('persons')->where('id', $user->id)->update(['pers_type' => 'a']);
                session(
                    [
                        'user_id' => $user->id,
                        'user_name' =>$user->login,
                        'role_id' => $user->role_name,
                        'branch_id' => $user->abit_branch_id
                    ]);
                return redirect('/dashboard');
            }

            
        }
        else //-----------Если не нашли среди сотрудников, смотрим среди абитуриентов ------------------------//
        {
            $persons = DB::table('persons')->where(['login' => $request->email])->first();
            if ($persons != null)
            {
                //----------- Проверка прошел активацию или нет ------------------------//
                if ($persons->secret_string == null) {
                    if (Hash::check($request->password, $persons->password)) {
                        //----------- Заблокирован или нет ------------------------//
                        if ($persons->is_block == 'F') {
                            session(
                            [
                                'person_id' => $persons->id,
                                'user_name' =>$persons->login,
                                'role_id' => 5
                            ]);
                            return redirect('/profile');
                        }
                    }
                }
            }
            return redirect('/');
        }
    }
}

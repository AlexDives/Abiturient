<?php

namespace App\Http\Controllers;

use Mail;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    public function index()
    {
        return view('RegisterPage.register',['title' => 'Регистрация']);
    }

    function check_login(Request $request)
    {
        if (DB::table('persons')->where('login', $request->log)->first() != null) return -1;
        else return 0;
    }

    function check_email(Request $request)
    {
        if (DB::table('persons')->where('email', $request->email)->first() != null) return -1;
        else return 0;
    }

   /* public function validator(array $data)
    {
        return Validator::make($data,
            [
            'login' => 'required|string|max:255',
            'password' => 'required|string|min:6|confirmed',
            'famil' => 'required|string|confirmed',
            'name' => 'required|string|confirmed',
            'otch' => 'required|string|confirmed',
            'secret' => 'required|string|min:6|confirmed',
        ]);
    }*/

    public function create(Request $request)
    {
        if (!filter_var($request->Email, FILTER_VALIDATE_EMAIL)) return -2;
        //if (!filter_var($request->Email, FILTER_VALIDATE_EMAIL)) return -2;
        // ваш секретный ключ
        $secret = '6LfwCtUUAAAAAJiz-peMncLSTkbHBLAPqyxomlF5';

        $captcha = $request->captcha;
        $verify = json_decode(file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=" . $secret . "&response=" . $captcha), true);

        if ($verify['success']) {
            $login      = $request->Name_login;
            $pass       = $request->Name_password;
            $email      = $request->Email;
            $famil      = $request->First_Name;
            $name       = $request->Name;
            $otch       = $request->Last_Name;
            $fio        = $famil.' '.$name.' '.$otch;

            //================= Генерация PIN кода =====================//
            $isEmployed = true;
            $pin = 0;
            while ($isEmployed) {
                $pin =  mt_rand(100000, 999999);
                $c = DB::table('persons')->where('pin', $pin)->first();
                $isEmployed = $c != null;
            }
            //==========================================================//

            $secret_string = '0123456789abcdefghijklmnopqrstuvwxyz';
                // Output: 54esmdr0qf
            $secret_string = substr(str_shuffle($secret_string), 0, 30);

            db::table('persons')->insert(
                [
                    'login'         => $login,
                    'password'      => Hash::make($pass),
                    'email'         => $email,
                    'famil'         => $famil,
                    'name'          => $name,
                    'otch'          => $otch,
                    'user_hash'     => Hash::make($login.Hash::make($pass)),
                    'PIN'           => $pin,
                    'secret_string' => $secret_string,
                    'pers_type'     => 'a'
                ]
            );

            $verificate_link = 'http://abit.ltsu.org/verificate?v='.$secret_string.'&email='.$email;
            Mail::send('RegisterPage.email', ['link' => $verificate_link, 'fio' => $fio], function ($message) use ($request) {
                $message->from('asu@ltsu.org', 'ЛНУ имени Тараса Шевченко');
                $message->to($request->Email, $request->First_Name.' '.$request->Name.' '.$request->Last_Name)->subject('Регистрация аккаунта на abit.ltsu.org');
            });
            return 0;
        } else if (!$verify['success']) {
            return 1;
        }
    }

    function verificate(Request $request)
    {
        if (isset($request->v) && isset($request->email))
        {
            $pers = DB::table('persons')->where('secret_string', $request->v)->where('email', $request->email)->first();
            if ($pers != null)
            {
                DB::table('persons')->where('id', $pers->id)->update(['secret_string' => null]);
                session(['person_id' => $pers->id, 'role_id' => 5]);
            }
        }
        echo '<script>location.replace("/");</script>';
    }
}

<?php

namespace App\Http\Controllers;

use Mail;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Validator;

class ProfileController extends Controller
{
	//  при регистрации нового заявления
	public function index_InsertAbit(Request $request)
	{
		$role = session('role_id');
		$users = session('user_name');
		$type_education = DB::table('abit_typeEducation')->get();
		$type_privileges = DB::table('abit_typePrivilege')->where('type', 1)->orderby('name','asc')->get();
		$predmet_zno = DB::table('abit_predmets')->where('is_zno', 'T')->orderby('name', 'asc')->get();
		$abit_typeDoc = DB::table('abit_typeDoc')->orderby('name', 'asc')->get();

		if ($request->session()->get('role_id') != 5) 
		{
			$pid = $request->session()->has('person_id') ? $request->session()->get('person_id') : $request->pid;
		}
		else $pid = $request->session()->get('person_id');
		if (isset($pid))
		{
			
			$person = DB::table('persons')->where('id', $pid)->first();
			$privileges = DB::table('abit_persPrivilege')
							->leftjoin('abit_typePrivilege', 'abit_typePrivilege.id', 'abit_persPrivilege.priv_id')
							->where('pers_id', $pid)
							->where('type', 1)->get();
			$pers_privilage = [];

			foreach($privileges as $p)
			{
				$pers_privilage += [
					$p->priv_id => $p->priv_id
				];
			}
			$doc_pers	= DB::table('abit_document as ad')
							->leftjoin('abit_typeEducation as ate', 'ate.id', 'ad.educ_id')
							->leftjoin('abit_typeDoc as atd', 'atd.id', 'ad.doc_id')
							->where('ad.pers_id', $pid)
							->whereIn('ad.doc_id', array(1,7))
							->first();

			
			$pers_zno = DB::table('abit_sertificate')
						->leftjoin('abit_predmets', 'abit_predmets.id', 'abit_sertificate.predmet_id')
						->where('person_id', $pid)
						->select('abit_sertificate.*', 'abit_predmets.name as pred_name')
						->get();

			return view('ProfilePage.old_insert_abit',
			[
				'title' 		=> 'Личная карточка',
				'role' 			=> $role,
				'username' 		=> $users,
				'person' 		=> $person,
				'typeEducation' => $type_education,
				'doc_pers'		=> $doc_pers,
				'privileges'    => $type_privileges,
				'pers_privilage'=> $pers_privilage,
				'predmet_zno'	=> $predmet_zno,
				'pers_zno'		=> $pers_zno,
				'abit_typeDoc'	=> $abit_typeDoc
			]);
		}
		else
		{
			return view('ProfilePage.old_insert_abit',
			[
				'title' 		=> 'Личная карточка',
				'role' 			=> $role,
				'username' 		=> $users,
				'typeEducation' => $type_education,
                'privileges'    => $type_privileges,
                'predmet_zno'	=> $predmet_zno,
				'abit_typeDoc'	=> $abit_typeDoc
			]);
		}
		
	}
	//Уже зарегистрированный абитуриент
	public function index_Success_Abit(Request $request)
	{
		$role = session('role_id');
		$users = session('user_name');
		return view('ProfilePage.success_profile',
			[
				'title' => 'Заявления',
				'role' => $role,
				'username' => $users
			]);
	}
	//Личная карточка куда попадает после регистрации (Абитуриент)
	public function index_Profile(Request $request)
	{
		$request->session()->forget('active_list');
		if ($request->session()->get('role_id') != 5) 
		{
			$pid = $request->pid;
			session(['person_id' => $pid]);
		}
		else $pid = $request->session()->get('person_id');
		$role = session('role_id');
		$users = session('user_name');
		$person = DB::table('persons')->where('id', $pid)->first();
		$person_statements = DB::table('abit_statements')
								->leftjoin('abit_group as g', 'g.id', 'abit_statements.group_id')
								->leftjoin('abit_facultet as af', 'af.id', 'g.fk_id')
								->leftjoin('abit_formObuch as fo', 'fo.id', 'g.fo_id')
								->where('abit_statements.person_id', $person->id)
								->select('af.name as fac_name', 'g.name as spec_name', 'abit_statements.shifr_statement', 'fo.name as form_obuch', 'abit_statements.date_return')
								->get();
		return view('ProfilePage.profile',
			[
				'title' => 'Личная карточка',
				'role' => $role,
				'person' => $person,
				'username' => $users,
				'person_statement' => $person_statements
			]);
	}
//-----------------------TEST-------------------------------------------------------------
    public function uploadDOCUMENTS(Request $request)
    {
        $path = storage_path('public/uploads');

        if (!file_exists($path)) {
            mkdir($path, 0777, true);
        }

        $file = $request->file('file');

        $name = uniqid() . '_' . trim($file->getClientOriginalName());

        $file->move($path, $name);

        return response()->json([
            'name'          => $name,
            'original_name' => $file->getClientOriginalName(),
        ]);
    }
    public function store(StoreProjectRequest $request)
    {
        $project = Project::create($request->all());

        foreach ($request->input('document', []) as $file) {
            $project->addMedia(storage_path('public/uploads/' . $file))->toMediaCollection('document');
        }

        return redirect()->route('projects.index');
    }

//------------------------------------------------------------------------------------
	//Загрузка новых изображений - В ЛИЧНОМ КАБИНЕТЕ
	public function upload_Photo(Request $request)
	{
		if($request->hasfile('FindFile'))
		{
			if ($request->file('FindFile')->isValid())
			{
				$max_size = (int)ini_get('upload_max_filesize') * 1000;
				$validator = Validator::make($request->all(), [
					'FindFile' => 'image',
					'FindFile' => 'mimetypes:image/jpeg,image/png,image/gif'. '|max:' . $max_size,
				]);

				if ($validator->fails()) {
					return -3;
				}

				$file = $request->file('FindFile');
				if ($file == null) return -4;
				$user_folder = $request->pid;

				$filename = $file->getClientOriginalName();

				$photoPath = env('APP_URL').'/upload/'.$user_folder.'/'.$filename;

				Storage::putFileAs('public/upload/'.$user_folder, $file, $filename);

				DB::table('persons')->where('id', $request->pid)->update(
					[
						'photo_url'	=> $photoPath
					]
				);
				return $photoPath;
			} else return -2;


		} else return -1;
	}

	public function save_Profile(Request $request)
	{
		/*$this->validate($request, [
			'FirstName' => 'required|string|min:2|max:50',
			'Name' => 'required|string|min:2|max:50',
			'SecondName' => 'required|string|min:2|max:50',
			'gender' => 'required',
			'phone_one' => 'required|string|min:10|max:20',
			'phone_two' => 'string|min:10|max:20',
			'birthday' => 'date',
			'citizen' => 'string',
			'language' => 'string',
			'country' => 'required|string|min:2|max:50',
			'adr_obl' => 'required|string|min:2|max:100',
			'adr_rajon' => 'required|string|min:2|max:100',
			'adr_city' => 'required|string|min:2|max:200',
			'adr_street' => 'required|string|min:2|max:200',
			'adr_house' => 'required|max:50',
			'adr_flatroom' => 'max:5',
			'type_doc' => 'required',
			'pasp_date' => 'required|date',
			'pasp_ser' => 'required|max:50',
			'pasp_num' => 'required|max:50',
			'pasp_vid' => 'required|max:500',
			'indkod' => 'max:50',
			'father_name' => 'max:50',
			'father_phone' => 'max:50',
			'mother_name' => 'max:50',
			'mother_phone' => 'max:50',
		  ]);*/
		if ($request->session()->get('role_id') != 5) $pid = $request->pid;
		else $pid = $request->session()->get('person_id');
		$famil 			= trim($request->FirstName);
		$name 			= trim($request->Name);
		$otch 			= trim($request->LastName);
		$gender 		= trim($request->gender);
		$phone_one 		= trim($request->phone_one);
		$phone_two 		= trim($request->phone_two);
		$email_abit 	= trim($request->email_abit);
		$birthday 		= trim($request->birthday);
		$citizen 		= trim($request->citizen);
		$en = 'F';
		$fr = 'F';
		$de = 'F';
		$ot = null;
		if(isset($request->language))
		{
			foreach($request->language as $lang)
			{
				switch($lang) {
					case 'EN' : $en = 'T'; break;
					case 'FR' : $fr = 'T'; break;
					case 'DE' : $de = 'T'; break;
					case 'OT' : $ot = 'T'; break;
				}
			}
		}

		$country 				= trim($request->country);
		$adr_obl 				= trim($request->adr_obl);
		$adr_rajon 				= trim($request->adr_rajon);
		$adr_city 				= trim($request->adr_city);
		$adr_street 			= trim($request->adr_street);
		$adr_house 				= trim($request->adr_house);
		$adr_flatroom 			= trim($request->adr_flatroom);
		$fact_residence			= trim($request->fact_residence);
		if ($fact_residence == '')
			$fact_residence = $country.' '.$adr_obl.' '.$adr_rajon.' '.$adr_city.' '.$adr_street.' д.'.$adr_house.' кв.'.$adr_flatroom;

		$type_doc 				= trim($request->type_doc);
		$pasp_date 				= trim($request->pasp_date);
		$pasp_ser 				= trim($request->pasp_ser);
		$pasp_num 				= trim($request->pasp_num);
		$pasp_vid 				= trim($request->pasp_vid);
		$indkod 				= trim($request->indkod);

		$abit_doc_id			= trim($request->adid);
		$educ_id				= trim($request->typeEducation);
		$uch_zav				= trim($request->uch_zav);
		$doc_id					= trim($request->doc_id);
		$doc_date				= trim($request->doc_date);
		$doc_ser				= trim($request->doc_ser);
		$doc_num				= trim($request->doc_num);
		$app_num				= trim($request->app_num);
		$sr_bal					= trim($request->sr_bal);
		$doc_vidan				= trim($request->doc_vidan);

		$father_name 			= trim($request->father_name);
		$father_phone 			= trim($request->father_phone);
		$mother_name 			= trim($request->mother_name);
		$mother_phone 			= trim($request->mother_phone);

		$zno_type 				= trim($request->zno_type);
		$zno_id 				= trim($request->zno_id);
		$zno_ball 				= trim($request->zno_ball);
		$zno_ser 				= trim($request->zno_ser);
		$zno_num 				= trim($request->zno_num);
		$zno_date 				= trim($request->zno_date);
		$zno_vidan 				= trim($request->zno_vidan);

		/**** общая инфа ****/
		if ($pid != -1)
		{
			DB::table('persons')->where('id', $pid)->update([
				'famil'     		=> $famil,
				'name'      		=> $name,
				'otch'      		=> $otch,
				'gender'      		=> $gender,
				'phone_one'    		=> $phone_one,
				'phone_two'    		=> $phone_two,
				'email'    			=> $email_abit,
				'birthday'       	=> date('Y-m-d', strtotime($birthday)),
				'citizen'     		=> $citizen,
				'country'     		=> $country,
				'adr_obl'     		=> $adr_obl,
				'adr_rajon'   		=> $adr_rajon,
				'adr_city'    		=> $adr_city,
				'adr_street'        => $adr_street,
				'adr_house'         => $adr_house,
				'adr_flatroom'      => $adr_flatroom,
				'fact_residence'    => $fact_residence,
				'type_doc'          => $type_doc,
				'pasp_date'         => date('Y-m-d', strtotime($pasp_date)),
				'pasp_ser'          => $pasp_ser,
				'pasp_num'          => $pasp_num,
				'pasp_vid'          => $pasp_vid,
				'indkod'            => $indkod,
				'english_lang'      => $en,
				'franch_lang'      	=> $fr,
				'deutsch_lang'      => $de,
				'other_lang'      	=> $ot,
				'father_name'       => $father_name,
				'father_phone'      => $father_phone,
				'mother_name'       => $mother_name,
				'mother_phone'      => $mother_phone,
			]);
		}
		else
		{
			$isEmployed = true;
            $pin = 0;
            while ($isEmployed) {
                $pin =  mt_rand(100000, 999999);
                $c = DB::table('persons')->where('pin', $pin)->first();
                $isEmployed = $c != null;
            }
			$secret_string = '0123456789abcdefghijklmnopqrstuvwxyz';
                // Output: 54esmdr0qf
			$login = substr(str_shuffle($secret_string), 0, 5);
			$pass = substr(str_shuffle($secret_string), 0, 10);
			
			
			$pid = DB::table('persons')->insertGetId([
				'login'         	=> $login,
				'password'      	=> Hash::make($pass),
				'user_hash'     	=> Hash::make($login.Hash::make($pass)),
                'PIN'           	=> $pin,
				'famil'     		=> $famil,
				'name'      		=> $name,
				'otch'      		=> $otch,
				'gender'      		=> $gender,
				'phone_one'    		=> $phone_one,
				'phone_two'    		=> $phone_two,
				'email'    			=> $email_abit,
				'birthday'       	=> date('Y-m-d', strtotime($birthday)),
				'citizen'     		=> $citizen,
				'country'     		=> $country,
				'adr_obl'     		=> $adr_obl,
				'adr_rajon'   		=> $adr_rajon,
				'adr_city'    		=> $adr_city,
				'adr_street'        => $adr_street,
				'adr_house'         => $adr_house,
				'adr_flatroom'      => $adr_flatroom,
				'fact_residence'    => $fact_residence,
				'type_doc'          => $type_doc,
				'pasp_date'         => date('Y-m-d', strtotime($pasp_date)),
				'pasp_ser'          => $pasp_ser,
				'pasp_num'          => $pasp_num,
				'pasp_vid'          => $pasp_vid,
				'indkod'            => $indkod,
				'english_lang'      => $en,
				'franch_lang'      	=> $fr,
				'deutsch_lang'      => $de,
				'other_lang'      	=> $ot,
				'father_name'       => $father_name,
				'father_phone'      => $father_phone,
				'mother_name'       => $mother_name,
				'mother_phone'      => $mother_phone,
				'pers_type'			=> 'a'
			]);

			Mail::send('RegisterPage.email', ['login' => $login, 'pass' => $pass, 'fio' => $famil.' '.$name.' '.$otch], function ($message) use ($request) {
				$message->from('asu@ltsu.org', 'ЛНУ имени Тараса Шевченко');
				$message->to($request->email_abit, $request->First_Name.' '.$request->Name.' '.$request->Last_Name)->subject('Создание аккаунта на abit.ltsu.org');
			});
		}

		/**** Доки об образовании ****/
		if ($abit_doc_id == -1)
		{
			DB::table('abit_document')->insert(
				[
					'pers_id'	=> $pid,
					'educ_id'	=> $educ_id,
					'doc_id'	=> $doc_id,
					'uch_zav'	=> $uch_zav,
					'doc_date'	=> date('Y-m-d', strtotime($doc_date)),
					'doc_ser'	=> $doc_ser,
					'doc_num'	=> $doc_num,
					'app_num'	=> $app_num,
					'sr_bal'	=> $sr_bal,
					'doc_vidan'	=> $doc_vidan
				]
			);
		}
		else
		{
			DB::table('abit_document')->where('pers_id', $pid)->update(
				[
					'educ_id'	=> $educ_id,
					'doc_id'	=> $doc_id,
					'uch_zav'	=> $uch_zav,
					'doc_date'	=> date('Y-m-d', strtotime($doc_date)),
					'doc_ser'	=> $doc_ser,
					'doc_num'	=> $doc_num,
					'app_num'	=> $app_num,
					'sr_bal'	=> $sr_bal,
					'doc_vidan'	=> $doc_vidan
				]
			);
		}

		/**** Льготы ****/
		DB::table('abit_persPrivilege')
					->leftjoin('abit_typePrivilege', 'abit_typePrivilege.id', 'abit_persPrivilege.priv_id')
					->where('pers_id', $pid)
					->where('type', 1)->delete();
		if(isset($request->type_priv))
		{
			foreach ($request->type_priv as $p)
				DB::table('abit_persPrivilege')->insert([
					'pers_id' => $pid,
					'priv_id' => $p
				]);
		}

		/**** ЕГЭ/ВНО ****/
		if($zno_num != '' && $zno_ser != '' && $zno_date != '' && $zno_ball != '' && $zno_vidan != '')
		{
			$tmp = DB::table('abit_sertificate')->where('person_id', $pid)->where('predmet_id', $zno_id)->first();
			if (isset($tmp))
				DB::table('abit_sertificate')->where('id', $tmp->id)->update([
					'type_sertificate' 	=> $zno_type,
					'ser_sert'			=> $zno_ser,
					'num_sert'			=> $zno_num,
					'date_sert'			=> $zno_date,
					'vidan_sert'		=> $zno_vidan,
					'ball_sert'			=> $zno_ball
				]);
			else
				DB::table('abit_sertificate')->insert([
					'person_id'			=> $pid,
					'predmet_id'		=> $zno_id,
					'type_sertificate' 	=> $zno_type,
					'ser_sert'			=> $zno_ser,
					'num_sert'			=> $zno_num,
					'date_sert'			=> date('Y-m-d', strtotime($zno_date)),
					'vidan_sert'		=> $zno_vidan,
					'ball_sert'			=> $zno_ball
				]);
		}
		return back()->with('active_list', $request->active_list);
	}
	public function delete_sertificate(Request $request)
	{
		if ($request->session()->get('role_id') != 5) $pid = $request->pid;
		else $pid = $request->session()->get('person_id');

		if (isset($request->serid))
		{
			DB::table('abit_sertificate')->where('person_id', $pid)->where('id', $request->serid)->delete();
		}
		return back()->with('active_list', $request->active_list);
	}
}

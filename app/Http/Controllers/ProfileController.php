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
			if (isset($request->pid))
			{
				if ($request->pid == -1)
				{
					$pid = $request->pid;
				}
			} 
			else 
			{
				$pid = $request->session()->has('person_id') ? $request->session()->get('person_id') : $request->pid;
			}
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
		if ($request->session()->get('role_id') != 5) 
		{
			$pid = $request->session()->has('person_id') ? $request->session()->get('person_id') : $request->pid;
		}
		else $pid = $request->session()->get('person_id');

		$abit_branch = DB::table('abit_branch')->get();

		return view('ProfilePage.success_profile',
			[
				'title' 		=> 'Заявления',
				'role' 			=> $role,
				'username' 		=> $users,
				'abit_branch'	=> $abit_branch,
				'person_id'		=> $pid
			]);
	}

	public function get_facultet(Request $request)
	{
		$fk = DB::table('abit_facultet')->where('branch_id', $request->bid)->orderBy('name', 'asc')->get();
		$data = "<option>Выберите элемент</option>";
		foreach ($fk as $f) {
			$data .= "<option value='".$f->id."'>".$f->name."</option>";
		}
		return $data;
	}

	public function get_stlevel(Request $request)
	{
		$stlevel = DB::table('abit_group as g')->distinct()->leftjoin('abit_stlevel as st', 'st.id', 'g.st_id')->where('g.fk_id', $request->fkid)->select('st.id', 'st.name')->orderBy('st.id', 'asc')->get();
		$data = "<option>Выберите элемент</option>";
		foreach ($stlevel as $st) {
			$data .= "<option value='".$st->id."'>".$st->name."</option>";
		}
		return $data;
	}

	public function get_form_obuch(Request $request)
	{
		$formobuch = DB::table('abit_group as g')->distinct()->leftjoin('abit_formObuch as fo', 'fo.id', 'g.fo_id')->where('g.fk_id', $request->fkid)->where('g.st_id', $request->stid)->select('fo.id', 'fo.name')->orderBy('fo.id', 'asc')->get();
		$data = "<option>Выберите элемент</option>";
		foreach ($formobuch as $fo) {
			$data .= "<option value='".$fo->id."'>".$fo->name."</option>";
		}
		return $data;
	}

	public function get_group(Request $request)
	{
		$group = DB::table('abit_group as g')
					->where('g.fk_id', $request->fkid)
					->where('g.st_id', $request->stid)
					->where('g.fo_id', $request->foid)
					->whereNotIn('g.id', function($query) use ($request){
						$query->select('group_id')
						->from('abit_statements')
						->where('person_id', $request->pid)
						->whereNull('date_return');
					})
					->orderBy('g.name', 'asc')->get();
		$data = "<option>Выберите элемент</option>";
		foreach ($group as $g) {
			$data .= "<option value='".$g->id."'>".$g->name."</option>";
		}
		return $data;
	}
	
	public function statement_return(Request $request)
	{
		if($request->has('ag'))
		{
			if ($request->ag > 0)
			{
				$statement = DB::table('abit_statements')->where('id', $request->ag)->where('person_id', $request->pid)->first();
				if ($statement->date_return == null)
				{
					DB::table('abit_statements')->where('id', $statement->id)->update([
						'date_return'	=> date('Y-m-d H:i:s', time()),
						'comment_return'=> 'Абитуриент отозвал заявление'
					]);
				}
			}
		}
		return back();
	}

	public function statement_create(Request $request)
	{
		if($request->has('abit_group'))
		{
			if ($request->abit_group > 0)
			{
				$tmp = DB::table('abit_statements')->where('group_id', $request->abit_group)->where('person_id', $request->pid)->count();
				if ($tmp == 0)
				{
					$count_in_group = DB::table('abit_statements')->where('group_id', $request->abit_group)->orderBy('id', 'desc')->first();
					if ($count_in_group == null) $count_in_group = 1;
					else $count_in_group = $count_in_group->queue_number + 1;

					$group = DB::table('abit_group as g')->leftjoin('abit_formObuch as fo', 'fo.id', 'g.fo_id')->select('g.*', 'fo.nick as fo_nick')->where('g.id', $request->abit_group)->first();

					$shifr = $group->fo_nick.$group->fo_id.$group->nick.$count_in_group;
					
					$AStatement_id = DB::table('abit_statements')->insertGetId([
						'person_id' 		=> $request->pid,
						'group_id'			=> $request->abit_group,
						'queue_number'		=> $count_in_group,
						'shifr_statement'	=> $shifr
					]);

					$group_exam = DB::table('abit_examenGroup')->where('group_id', $request->abit_group)->get();
					foreach ($group_exam as $ge) {
						$tmp = DB::table('abit_examCard')->where('state_id', $AStatement_id)->where('exam_id', $ge->id)->count();
						if ($tmp == 0)
						{
							$grafik = DB::table('abit_grafikExam')->where('predmet_id', $ge->predmet_id)->where('fo_id', $group->fo_id)->where('st_id', $group->st_id)->first();
							if ($grafik != null)
								DB::table('abit_examCard')->insert(['state_id' => $AStatement_id, 'exam_id' => $ge->id, 'date_exam' => $grafik->date_exam]);
							else 
								DB::table('abit_examCard')->insert(['state_id' => $AStatement_id, 'exam_id' => $ge->id]);
							
							$tmp = DB::table('pers_events')->where('pers_id', $request->pid)->where('event_id', '6')->first(); 	// ТУТ СТОИТ ФИКСИРОВАННОЕ ПОЛЕ EVENT_ID = 6, ЭТО КОСТЫЛЬ И ПРИДЕТСЯ МЕНЯТЬ КАЖДЫЙ ГОД ДАННОЕ ЧИСЛО ИЗ ТАБЛИЦЫ EVENTS
							if ($tmp == null) $event_pers = DB::table('pers_events')->insertGetId([ 'pers_id' => $request->pid, 'event_id' => '6' ]);		// ТУТ СТОИТ ФИКСИРОВАННОЕ ПОЛЕ EVENT_ID = 6, ЭТО КОСТЫЛЬ И ПРИДЕТСЯ МЕНЯТЬ КАЖДЫЙ ГОД ДАННОЕ ЧИСЛО ИЗ ТАБЛИЦЫ EVENTS
							else $event_pers = $tmp->id;
							$tid = DB::table('abit_predmets')->where('id', $ge->predmet_id)->first()->test_id;
							$tmp = DB::table('pers_tests')->where('pers_id', $request->pid)->where('test_id', $tid)->where('pers_event_id', $event_pers)->count();
							if ($tmp == 0)
							{
								if ($grafik != null)
									DB::table('pers_tests')->insert(['pers_id' => $request->pid, 'test_id' => $tid, 'pers_event_id' => $event_pers, 'start_time' => $grafik->date_exam ]);
								else 
									DB::table('pers_tests')->insert(['pers_id' => $request->pid, 'test_id' => $tid, 'pers_event_id' => $event_pers ]);
							}
						}
					}
					return redirect('/profile');
				}
				else return back();
			}
			else return back();
		}
		else return back(); 
	}

	public function checked_abit(Request $request)
	{
		DB::table('persons')->where('id', $request->pid)->update(['is_checked' => 'T']);
		$person = DB::table('persons')->where('id', $request->pid)->first();
		$pers_test = DB::table('pers_tests')->where('pers_id', $request->pid)->whereNull('start_time')->get();
		foreach ($pers_test as $pt) {
			DB::table('pers_tests')->where('id', $pt->id)->update([ 'start_time' => date('Y-m-d H', time()) ]);
		}
		$pers_test = DB::table('pers_tests as pt')
						->leftjoin('tests as t', 't.id', 'pt.test_id')
						->leftjoin('target_audience as ta', 'ta.id', 't.targetAudience_id')
						->leftjoin('pers_events as pe', 'pe.id', 'pt.pers_event_id')
						->select('pt.*', 't.discipline', 'ta.name as targetAudience_name')
						->where('pe.event_id', '6')->where('pt.pers_id', $request->pid)->get(); // ТУТ СТАТИЧЕСКОЕ ЗНАЧЕНИЕ, КОТОРОЕ НУЖНО БУДЕТ МЕНЯТЬ КАЖДЫЙ ГОД EVENT_ID
		Mail::send('MailsTemplate.MailCheckedAbit', ['person' => $person, 'pers_test' => $pers_test], function ($message) use ($person) {
            $message->from('abiturient@ltsu.org', 'Информация с abit.ltsu.org');
            $message->to($person->email, $person->famil.' '.$person->name.' '.$person->otch)->subject('Ваша учетная запись прошла проверку');
        });
		return back();
		//return view('MailsTemplate.MailCheckedAbit', ['person' => $person, 'pers_test' => $pers_test]);
	}

	//Личная карточка куда попадает после регистрации (Абитуриент)
	public function index_Profile(Request $request)
	{
		$request->session()->forget('active_list');
		if ($request->session()->get('role_id') != 5) 
		{
			if($request->has('pid'))
			{
				$pid = $request->pid;
				session(['person_id' => $pid]);
			}
			else return redirect('/');
		}
		else $pid = $request->session()->get('person_id');
		$role = session('role_id');
		$users = session('user_name');
		$person = DB::table('persons')->where('id', $pid)->first();
		$pers_zno = DB::table('abit_sertificate')
					->leftjoin('abit_predmets', 'abit_predmets.id', 'abit_sertificate.predmet_id')
					->where('person_id', $pid)
					->select('abit_sertificate.*', 'abit_predmets.name as pred_name')
					->get();

		$doc_obr = DB::table('abit_document as d')
						->leftjoin('abit_typeDoc as td', 'td.id', 'd.doc_id')
						->leftjoin('abit_typeEducation as te', 'te.id', 'd.educ_id')
						->where('d.pers_id', $person->id)
						->whereIn('d.doc_id', [1, 7])
						->select('d.*', 'td.name as typeDoc_name', 'te.name as typeEduc_name')
						->first();

		$person_statements = DB::table('abit_statements')
								->leftjoin('abit_group as g', 'g.id', 'abit_statements.group_id')
								->leftjoin('abit_facultet as af', 'af.id', 'g.fk_id')
								->leftjoin('abit_formObuch as fo', 'fo.id', 'g.fo_id')
								->leftjoin('abit_stlevel as st', 'st.id', 'g.st_id')
								->where('abit_statements.person_id', $person->id)
								->select('af.name as fac_name', 'g.name as spec_name', 'abit_statements.shifr_statement', 'fo.name as form_obuch', 'abit_statements.date_return', 'abit_statements.id', 'st.name as stlevel_name')
								->get();
		$person_tests = [];
		$persTests = [];
		$successTest = [];
		$statusTest = [];

		foreach ($person_statements as $ps) {
			if ($ps->date_return == null) {
				$person_tests = DB::table('abit_examCard as ec')
								->leftjoin('abit_examenGroup as eg', 'eg.id', 'ec.exam_id')
								->leftjoin('abit_predmets as p', 'p.id', 'eg.predmet_id')
								->leftjoin('pers_tests as pt', 'pt.test_id', 'p.test_id')
								->leftjoin('pers_events as pe', 'pe.id', 'pt.pers_event_id')
								->leftjoin('tests', 'tests.id', 'pt.test_id')
								->where('ec.state_id', $ps->id)
								->where('pt.pers_id', $person->id)
								->select(
									'pt.id',
									'tests.id as test_id',
									'tests.discipline',
									'pt.status',
									'pt.start_time',
									'pt.end_time',
									'pt.test_ball_correct',
									'pt.last_active',
									'tests.max_ball',
									'tests.min_ball',
									'tests.count_question',
									'pt.minuts_spent',
									'pt.pers_event_id'
								)
								->where('pe.event_id', '6') 								// ТУТ ФИКСИРОВАННОЕ ЗНАЧЕНИЕ - КОСТЫЛЬ, ПОНАДОБИТСЯ КАЖДЫЙ ГОД МЕНЯТЬ EVENT_ID НА НУЖНЫЙ
								->get();
				
				$persTests += [$ps->id => $person_tests];

				foreach ($person_tests as $test) {	
					$testScatter_success = true;
					$max_ball = 0;
					$max_quest = 0;
					$tc = DB::table('test_scatter')
							->where('test_id', $test->test_id)
							->orderBy('ball', 'asc')
							->get();

					if (count($tc) == 0) $testScatter_success = false;
					
					foreach ($tc as $tmp)
					{
						$max_ball += $tmp->ball_count * $tmp->ball;
						$max_quest += $tmp->ball_count;
		
						$ttmp = DB::table('questions')->where('test_id', $test->test_id)->where('ball', $tmp->ball)->count();
						if ($tmp->ball_count <= $ttmp) $testScatter_success= true;
						else $testScatter_success = false;
					}
					if ($max_ball != $test->max_ball) $testScatter_success = false;
					if ($max_quest != $test->count_question) $testScatter_success = false;
					// добавить проверку на дату и время ивента этого теста
					$event = DB::table('pers_events')
								->leftjoin('events', 'events.id', 'pers_events.event_id')
								->where('pers_events.id', $test->pers_event_id)
								->select('events.*')
								->first();
		
					if((strtotime($event->date_start) <= time()) && (strtotime($event->date_end) >= time()) || $test->status == 2) 
					{
						if ($test->start_time != null)
						{ 
							$timestampStart = strtotime($test->start_time);
							$timestampEnd = time();
							$seconds = ($timestampEnd - $timestampStart);
							$testScatter_success = $seconds >= 172800 ? false : true; // 172800 sec == 2 days
						}
						else $testScatter_success = false;
					}
					else $testScatter_success = false;
		
					if ($testScatter_success || in_array($test->status, [2, 3])) 
					{
						switch ($test->status) {
							case 0:
								$status = "<span onclick='startTest(".$test->id.",".$test->status.",\"".$person->user_hash."\");' style='cursor:pointer;background-color: forestgreen;' class='badge badge-primary'>Готов к прохождению</span>";
								break;
							case 1:
								$status = "<span onclick='startTest(".$test->id.",".$test->status.",\"".$person->user_hash."\");' style='cursor:pointer;' class='badge badge-warning'>В процессе</span>";
								break;
							case 2:
								$status = $test->test_ball_correct >= $test->min_ball ? 
											"<span onclick='shortResult(".$test->id.",\"".$person->user_hash."\");' style='cursor:pointer;' class='badge badge-success'>Пройден</span>" : 
											"<span onclick='shortResult(".$test->id.",\"".$person->user_hash."\");' style='cursor:pointer;' class='badge badge-danger'>Не пройден</span>";
								break;
							case 3:
								$status = "<span onclick='startTest(".$test->id.",".$test->status.",\"".$person->user_hash."\");' style='cursor:pointer;' class='badge badge-danger'>Приостановлен</span>";
								break;
						}
						$successTest += [
							$test->id => "true"
						];
					}
					else 
					{
						$status = "<span class='badge badge-danger'>Тест не доступен</span>";
						$successTest += [
							$test->id => "false"
						];
					}
					$statusTest += [
						$test->id => $status
					];
				}
			}
		}
 
		$person_count_statements = DB::table('abit_statements')->where('person_id', $person->id)->whereNull('date_return')->count();
		return view('ProfilePage.profile',
			[
				'title' => 'Личная карточка',
				'role' => $role,
				'person' => $person,
				'username' => $users,
				'person_statement' => $person_statements,
				'persTests'	=> $persTests,
				'person_count_statements' => $person_count_statements,
				'statusTest'    => $statusTest,
				'successTest'   => $successTest,
				'doc_obr'		=> $doc_obr,
				'pers_zno'		=> $pers_zno
			]);
	}

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
		$hostel_need 	= isset($request->hostel_need) ? trim($request->hostel_need) : 0;
		
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
				'hostel_need'       => $hostel_need,
				'pers_type'			=> 'a'
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
				'pers_type'			=> 'a',
				'hostel_need'       => $hostel_need
			]);

			Mail::send('RegisterPage.email', ['login' => $login, 'pass' => $pass, 'fio' => $famil.' '.$name.' '.$otch], function ($message) use ($request) {
				$message->from('abiturient@ltsu.org', 'ЛНУ имени Тараса Шевченко');
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
					'sr_bal'	=> $sr_bal == '' ? null : $sr_bal,
					'doc_vidan'	=> $doc_vidan
				]
			);
		}
		else
		{
			DB::table('abit_document')->where('pers_id', $pid)->where('doc_id', $abit_doc_id)->update(
				[
					'educ_id'	=> $educ_id,
					'doc_id'	=> $doc_id,
					'uch_zav'	=> $uch_zav,
					'doc_date'	=> date('Y-m-d', strtotime($doc_date)),
					'doc_ser'	=> $doc_ser,
					'doc_num'	=> $doc_num,
					'app_num'	=> $app_num,
					'sr_bal'	=> $sr_bal == '' ? null : $sr_bal,
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

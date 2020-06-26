@extends('layout.layout-2')

@section('styles')
	<!-- Page -->
	<link rel="stylesheet" href="{{ asset('assets/vendor/css/pages/users.css') }}">
	<link href="{{ asset('fonts/fonts/font-awesome.min.css') }}" rel="stylesheet">
	<link href="{{ asset('css/toastr.min.css') }}" rel="stylesheet">
	<link href="{{ asset('css/style.css') }}" rel="stylesheet">
@endsection

@section('scripts')
	<script src="{{ asset('js/toastr.min.js') }}"></script>
	<script src="{{ asset('js/profile.js') }}"></script>
	<script>
		var role = {{ $role }};
        function startTest(testPersId, status, hash)
        {
            if (testPersId != 0 && status != 2)
            {
                let form = document.createElement('form');
                form.action = 'https://test.ltsu.org/test/start';
                form.method = 'POST';
                form.innerHTML = '<input name="ptid" value="' + testPersId + '"><input name="_hash" value="' + hash + '">{{ csrf_field() }}';
                document.body.append(form);
                form.submit();
            }
        }

        function shortResult(testPersId, hash)
        {
            let form = document.createElement('form');
            form.action = 'https://test.ltsu.org/test/result/short';
            form.method = 'POST';
            form.target = '_blank';
            form.innerHTML = '<input name="ptid" value="' + testPersId + '"><input name="_hash" value="' + hash + '">{{ csrf_field() }}';
            document.body.append(form);
            form.submit();
        }

		function toggle_table(id){
			//$( ".hidden_card_table" ).toggle();
			$( ".hidden_card_table" + id ).slideToggle();

		}
	</script>
@endsection

@section('content')
	<div class="media align-items-center py-3 mb-3">
		<img src="{{ $person->photo_url }}" alt="" class="d-block ui-w-100 rounded-circle" id="photo_main">
		<div class="media-body ml-4">
			<h4 class="font-weight-bold mb-0">{{ $person->famil.' '.$person->name.' '.$person->otch }}</h4>
			<div class="text-muted mb-2">E-mail: {{ $person->email }}</div>
			<span class="profile-time-func">
			@if($person->is_checked == 'F' || $role != 5)

				<a href="javascript:void(0)" class="btn btn-primary btn-sm" onclick="FindFile();"><i class="ion ion-md-photos"></i> Фото</a>
				<form action="#" method="POST" enctype="multipart/form-data" id="loadPhoto" style="position:absolute;overflow: hidden;display:block;height:0px;width:0px;">
					<input type="file"   id="FindFile" accept="image/jpeg,image/png,image/gif" name="FindFile" onchange="LoadFile();" style="display: none">
					<input type="hidden" name="pid" value="{{ $person->id }}">
					<input type="submit" id="loadFile" style="display: none" value='Загрузить'>
				</form>
				<iframe id="rFrame" name="rFrame" style="display: none"> </iframe>
				<a href="{{ url('/insert_abit') }}" class="btn btn-default btn-sm"><i class="ion ion-md-person "></i> Данные</a>
				@if($person_count_statements > 0)<a href="{{ url('/scanPhoto') }}" class="btn btn-default btn-sm"><i class="ion ion-md-images "></i> Скан фото</a>@endif
				<div class="demo-paragraph-spacing mt-3">
					@if($person_count_statements < 6) <a href="{{ url('/success_insert_abit') }}" class="btn btn-primary"><i class="ion ion-md-add"></i> Добавить заявление</a> @endif
					@if($role != 5 && $person->is_checked == 'F') <a href="{{ url('/checked_abit?pid='.$person->id) }}" class="btn btn-success"><i class="ion ion-md-checkmark"></i> Проверено</a>
					@elseif($role != 5) Проверено@endif
				</div>
			@else
				Проверено
			@endif
		</span>
		</div>
	</div>

	<div class="card mb-4">
		<div class="card-body">
			<table class="table user-view-table m-0">
				<tbody>
				<tr>
					<td>Регистрация:</td>
					<td>{{ date('d/m/Y', strtotime($person->date_crt)) }}</td>
				</tr>
				<tr>
					<td>Нуждается в общежитии:</td>
					<td><span class="badge badge-outline-success">{{ $person->hostel_need == 1 ? 'Да' : 'Нет' }}</span></td>
				</tr>
				<!--<tr>
					<td>Количество фотографий:</td>
					<td><span class="badge badge-outline-success">{{ $person->count_photo }}</span></td>
				</tr>
				<tr>
					<td>Оригинал документов:</td>
					<td><span class="badge badge-outline-danger">{{ $person->is_orig == 'T' ? 'Да' : 'Нет' }}</span></td>
				</tr>-->
				</tbody>
			</table>
		</div>
		<hr class="border-light m-0">
		<div class="table-responsive">
			<table class="table card-table m-0">
				<thead>
					<tr>
						<th class="align-middle">Институт / факультет</th>
						<th class="align-middle">Направление</th>
						<th class="align-middle">Образовательный уровень</th>
						<th class="align-right">Форма обучения</th>
						<th class="align-right">Возврат</th>
					</tr>
				</thead>
				<tbody>
					@if(count($person_statement) > 0)
						@foreach ($person_statement as $ps)
							<tr onClick="toggle_table({{ $ps->id }})" class="visible_card_table_td"
								@if($ps->date_return != null)
									style="background-color: #ffad5e;"
								@endif
								>
								<td class="align-middle">{{ $ps->fac_name }}</td>
								<td class="align-middle">{{ $ps->spec_name }}</td>
								<td class="align-middle">{{ $ps->stlevel_name }}</td>
								<td class="align-middle">{{ $ps->form_obuch }}</td>
								<td>@if($person->is_checked == 'F')@if($ps->date_return == null)<a href="{{ url('/statement/return?ag=').$ps->id.'&pid='.$person->id }}" class="ion ion-md-close text-light"></a>@else <span class="ion ion-md-close text-light"></span> @endif @endif</td>
							</tr>
							<tr>
								<td colspan="5">
									<span class="hidden_card_table hidden_card_table{{ $ps->id }}">
										<table class="table card-table table-vcenter text-nowrap  align-items-center">
											<thead class="thead-light">
												<tr>
													<th>№</th>
													<th>Название теста</th>
													<th class='text-center'>Статус</th>
													<th class='text-center'>Дата прохождения</th>
													<th class='text-center'>Затраченное время</th>
													<th class='text-center'>Баллов</th>
												</tr>
											</thead>
											<tbody>
												@if(isset($persTests[$ps->id]))
													@foreach ($persTests[$ps->id] as $pt)
														@if (isset($pt->discipline))
															<tr>
																<td>{{$loop->iteration}}</td>
																<td class="align-middle">{{ $pt->discipline }}</td>
																<td class='text-center'><?php echo htmlspecialchars_decode($statusTest[$pt->id]); ?></td>
																<td class='text-center'>{{ $pt->start_time != null ? date('d.m.Y H:i', strtotime($pt->start_time)) : ''}}</td>
																<td class='text-center'>
																	@if (!empty($pt->minuts_spent)){{ $pt->minuts_spent }} мин. @endif
																</td>
																<td class='text-center'>{{ $pt->test_ball_correct }}</td>
															</tr>
														@endif
													@endforeach
												@endif
											</tbody>
										</td>
									</table>
								</span>
							</tr>
						@endforeach
					@else
						<tr>
							<td colspan="5" class="text-center">
								Нет заявлений
							</td>
						</tr>
					@endif
				</tbody>
			</table>
		</div>
	</div>
	<div class="card">
		<div class="card text-center mb-3">
			<div class="nav-tabs-top mb-4">
				<div class="card-header">
					<ul class="nav nav-pills card-header-pills nav-responsive-md">
						<li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#navs-top-info" style="">Основная информация</a></li>
						<li class="nav-item"><a class="nav-link" data-toggle="tab" href="#navs-top-passport" style="">Паспортные данные</a></li>
						<li class="nav-item"><a class="nav-link" data-toggle="tab" href="#navs-top-parents" style="">Информация о родителях</a></li>
						<li class="nav-item"><a class="nav-link" data-toggle="tab" href="#navs-top-education" style="">Информация об образовании</a></li>
						<li class="nav-item"><a class="nav-link" data-toggle="tab" href="#navs-top-ball" style="">Результаты ЕГЭ/ВНО</a></li>
					</ul>
				</div>
				<div class="tab-content">
					<div class="tab-pane fade active show" id="navs-top-info">
						<div class="card-body">
							<div class="form-row">
								<div class="form-group col-md-2">
									<label class="form-label">Фамилия</label>
									<input type="text" class="form-control" placeholder="Иванов" value="{{ $person->famil }}" disabled="true">
								</div>
								<div class="form-group col-md-2">
									<label class="form-label">Имя</label>
									<input type="text" class="form-control" placeholder="Иван" value="{{ $person->name }}" disabled="true">
								</div>
								<div class="form-group col-md-2">
									<label class="form-label">Отчество</label>
									<input type="text" class="form-control" placeholder="Иванович" value="{{ $person->otch }}" disabled="true">
								</div>
								<div class="form-group col-md-2">
									<label class="form-label">Дата рождения</label>
									<input type="text" class="form-control" value="{{ $person->birthday }}" disabled="true">
								</div>
								<div class="form-group col-md-2">
									<label class="form-label">Пол</label>
									<input type="text" class="form-control" placeholder="Пол" value="@if($person->gender == 'Муж') Мужской @elseif($person->gender == 'Жен') Женский @else @endif" disabled="true">
								</div>
							</div>
							<div class="form-row">
								<div class="form-group col-md-2">
									<label class="form-label">Страна</label>
									<input type="text" class="form-control" value="{{$person->country}}" disabled="true">
								</div>
								<div class="form-group col-md-2">
									<label class="form-label">Область/Регион</label>
									<input type="text" class="form-control" value="{{$person->adr_obl}}" disabled="true">
								</div>
								<div class="form-group col-md-2">
									<label class="form-label">Район</label>
									<input type="text" class="form-control" value="{{$person->adr_rajon}}" disabled="true">
								</div>
								<div class="form-group col-md-2">
									<label class="form-label">Населенный пункт</label>
									<input type="text" class="form-control" value="{{$person->adr_city}}" disabled="true">
								</div>
								<div class="form-group col-md-2">
									<label class="form-label">Улица</label>
									<input type="text" class="form-control"value="{{$person->adr_street}}" disabled="true">
								</div>
							</div>
							<div class="form-row">
								<div class="form-group col-md-2">
									<label class="form-label">Дом</label>
									<input type="text" class="form-control" value="{{$person->adr_house}}" disabled="true">
								</div>
								<div class="form-group col-md-2">
									<label class="form-label">Квартира</label>
									<input type="text" class="form-control" value="{{$person->adr_flatroom}}" disabled="true">
								</div>
								<div class="form-group col-md-6">
									<label class="form-label">Адрес фактического проживания</label>
									<input type="text" class="form-control" disabled="true" value="{{$person->fact_residence}}" disabled="true">
								</div>
							</div>
							<div class="form-row">

								<div class="form-group col-md-2">
									<label class="form-label">Номер телефона 1</label>
									<input type="text" class="form-control" value="{{$person->phone_one}}" disabled="true">
								</div>
								<div class="form-group col-md-2">
									<label class="form-label">Номер телефона 2</label>
									<input type="text" class="form-control" value="{{$person->phone_two}}" disabled="true">
								</div>
								<div class="form-group col-md-6">
									<label class="form-label">Владение языками</label>
									<input type="text" class="form-control" value="{{$person->english_lang == 'T' ? 'Английский ' : '' }}{{$person->franch_lang == 'T' ? 'Фанцузский ' : '' }}{{$person->deutsch_lang == 'T' ? 'Немецкий ' : '' }}{{$person->other_lang != '' ? $person->other_lang : '' }}" disabled="true">
								</div>
							</div>
						</div>
					</div>
					<div class="tab-pane fade" id="navs-top-passport">
						<div class="card-body">
							<div class="form-row">
								<div class="form-group col-md-2">
									<label class="form-label">Тип документа</label>
									<input type="text" class="form-control" placeholder="Паспорт" value="{{ $person->type_doc }}" disabled="true">
								</div>
								<div class="form-group col-md-2">
									<label class="form-label">Серия документа</label>
									<input type="text" class="form-control" placeholder="ТН" value="{{ $person->pasp_ser }}" disabled="true">
								</div>
								<div class="form-group col-md-2">
									<label class="form-label">Номер документа</label>
									<input type="text" class="form-control" placeholder="123456" value="{{ $person->pasp_num }}" disabled="true">
								</div>
								<div class="form-group col-md-2">
									<label class="form-label">Дата выдачи дкоумента</label>
									<input type="text" class="form-control" placeholder="01.01.2020" value="{{ $person->pasp_date }}" disabled="true">
								</div>
								<div class="form-group col-md-4">
									<label class="form-label">Идентификационный код</label>
									<input type="text" class="form-control" placeholder="12345678910" value="{{ $person->indkod }}" disabled="true">
								</div>
							</div>
							<div class="form-row">
								<div class="form-group col-md-12">
									<label class="form-label">Где и кем выдан документ</label>
									<input type="text" class="form-control" placeholder="Артемевским РО УМВД ЛНР" value="{{ $person->pasp_vid }}" disabled="true">
								</div>
							</div>
						</div>
					</div>
					<div class="tab-pane fade" id="navs-top-parents">
						<div class="card-body">
							<div class="form-row">
								<div class="form-group col-md-3">
									<label class="form-label">ФИО отца </label>
									<input type="text" class="form-control" placeholder="" value="{{ $person->father_name }}" disabled="true">
								</div>
								<div class="form-group col-md-5">
									<label class="form-label">Телефон отца</label>
									<input type="text" class="form-control" placeholder="" value="{{ $person->father_phone }}" disabled="true">
								</div>
							</div>
							<div class="form-row">
								<div class="form-group col-md-3">
									<label class="form-label">ФИО матери </label>
									<input type="text" class="form-control" placeholder="" value="{{ $person->mother_name }}" disabled="true">
								</div>
								<div class="form-group col-md-5">
									<label class="form-label">Телефон матери</label>
									<input type="text" class="form-control" placeholder="" value="{{ $person->mother_phone }}" disabled="true">
								</div>
							</div>
						</div>
					</div>
					<div class="tab-pane fade" id="navs-top-education">
						<div class="card-body">
							<div class="form-row">
								<div class="form-group col-md-3">
									<label class="form-label">Образовательный уровень</label>
									<input type="text" class="form-control" placeholder="" value="{{ isset($doc_obr) ? $doc_obr->typeEduc_name : ''}}" disabled="true">
								</div>
								<div class="form-group col-md-3">
									<label class="form-label">Док-то об образовании</label>
									<input type="text" class="form-control" placeholder="" value="{{ isset($doc_obr) ? $doc_obr->typeDoc_name : '' }}" disabled="true">
								</div>
								<div class="form-group col-md-2">
									<label class="form-label">Серия документа</label>
									<input type="text" class="form-control" placeholder="" value="{{ isset($doc_obr) ? $doc_obr->doc_ser : '' }}" disabled="true">
								</div>
								<div class="form-group col-md-2">
									<label class="form-label">Номер документа</label>
									<input type="text" class="form-control" placeholder="" value="{{ isset($doc_obr) ? $doc_obr->doc_num : '' }}" disabled="true">
								</div>
								<div class="form-group col-md-2">
									<label class="form-label">Дата выдачи</label>
									<input type="text" class="form-control" placeholder="" value="{{ isset($doc_obr) ? $doc_obr->doc_date != null ? date('d.m.Y', strtotime($doc_obr->doc_date)) : '' : '' }}" disabled="true">
								</div>
							</div>
							<div class="form-row">
								<div class="form-group col-md-2">
									<label class="form-label">Серия и номер приложения</label>
									<input type="text" class="form-control" placeholder="" value="{{ isset($doc_obr) ? $doc_obr->app_num : '' }}" disabled="true">
								</div>
								<div class="form-group col-md-1">
									<label class="form-label">Средний балл</label>
									<input type="text" class="form-control" placeholder="" value="{{ isset($doc_obr) ? $doc_obr->sr_bal : '' }}" disabled="true">
								</div>
								<div class="form-group col-md-5">
									<label class="form-label">Кем выдан документ</label>
									<input type="text" class="form-control" placeholder="" value="{{ isset($doc_obr) ? $doc_obr->doc_vidan : '' }}" disabled="true">
								</div>
								<div class="form-group col-md-4">
									<label class="form-label">Учебное заведение</label>
									<input type="text" class="form-control" placeholder="" value="{{ isset($doc_obr) ? $doc_obr->uch_zav : '' }}" disabled="true">
								</div>
							</div>
						</div>
					</div>
					<div class="tab-pane fade" id="navs-top-ball">
						<div class="card-body">
							<div class="table-responsive">
								<table class="table table-hover" style="cursor: default;">
									<thead>
										<tr>
											<th class="text-center">№</th>
											<th class="text-center">Тип</th>
											<th class="text-center">Серия и номер</th>
											<th class="text-center">Предмет</th>
											<th class="text-center">Балл</th>
											<th class="text-center">Дата</th>
										</tr>
									</thead>
									<tbody>
										@if(isset($pers_zno))
											@if(count($pers_zno) > 0)
												@foreach ($pers_zno as $pz)
													<tr onclick="select_zno({{ '\''.$pz->type_sertificate.'\',\''.$pz->ser_sert.'\',\''.$pz->num_sert.'\',\''.$pz->predmet_id.'\',\''.$pz->ball_sert.'\',\''.$pz->date_sert.'\'' }});">
														<th class="text-center" scope="row">{{ $loop->iteration }}</th>
														<td class="text-center">{{ $pz->type_sertificate }}</td>
														<td class="text-center">{{ $pz->ser_sert.' '.$pz->num_sert }}</td>
														<td class="text-center">{{ $pz->pred_name }}</td>
														<td class="text-center">{{ $pz->ball_sert }}</td>
														<td class="text-center">{{ $pz->date_sert }}</td>
													</tr>
												@endforeach
											@else
												<tr>
													<td colspan="7" class="text-center">
														Нет сертификатов
													</td>
												</tr>
											@endif
										@endif
									</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<script src="{{ asset('js/timescript.js') }}"></script>
@endsection

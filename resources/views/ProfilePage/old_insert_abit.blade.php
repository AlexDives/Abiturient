@extends('layout.layout-2')

@section('styles')
	<link rel="stylesheet" href="{{ asset('assets/vendor/libs/bootstrap-select/bootstrap-select.css') }}">
	<link rel="stylesheet" href="{{ asset('assets/vendor/libs/bootstrap-tagsinput/bootstrap-tagsinput.css') }}">
	<!--<link rel="stylesheet" href="{{ asset('assets/vendor/libs/dropzone/dropzone.css')}}">-->
	<!-- Page -->
	<link rel="stylesheet" href="{{ asset('assets/vendor/css/pages/account.css') }}">
	<style>
		.dropdown-menu .show{
			max-height: 200px;
			overflow: hidden scroll;
		}
	</style>
@endsection

@section('scripts')
	<!-- Dependencies -->
	<script src="{{asset('assets/vendor/libs/bootstrap-select/bootstrap-select.js')}}"></script>
	<script src="{{ asset('assets/vendor/libs/bootstrap-tagsinput/bootstrap-tagsinput.js') }}"></script>

	<!--<script src="{{asset('assets/vendor/libs/dropzone/dropzone.js')}}"></script>-->
	<!--<script src="{{asset('assets/js/forms_file-upload.js')}}"></script>-->
	<!-- Маски ввода -->
	<script src="{{ asset('assets/vendor/libs/vanilla-text-mask/vanilla-text-mask.js') }}"></script>
	<script src="{{ asset('assets/vendor/libs/vanilla-text-mask/text-mask-addons.js') }}"></script>
	<script>
		//даты рождения абитуриента
		vanillaTextMask.maskInput({
			inputElement: $('#date_birth')[0],
			mask: [/\d/, /\d/, '.', /\d/, /\d/, '.', /\d/, /\d/, /\d/, /\d/],
			pipe: textMaskAddons.createAutoCorrectedDatePipe('dd.mm.yyyy')
		});
		//даты выдачи
		vanillaTextMask.maskInput({
			inputElement: $('#date_vidach')[0],
			mask: [/\d/, /\d/, '.', /\d/, /\d/, '.', /\d/, /\d/, /\d/, /\d/],
			pipe: textMaskAddons.createAutoCorrectedDatePipe('dd.mm.yyyy')
		});
		//даты выдачи
		vanillaTextMask.maskInput({
			inputElement: $('#date_sert')[0],
			mask: [/\d/, /\d/, '.', /\d/, /\d/, '.', /\d/, /\d/, /\d/, /\d/],
			pipe: textMaskAddons.createAutoCorrectedDatePipe('dd.mm.yyyy')
		});
		//даты выдачи
		vanillaTextMask.maskInput({
			inputElement: $('#date_vidach_doc')[0],
			mask: [/\d/, /\d/, '.', /\d/, /\d/, '.', /\d/, /\d/, /\d/, /\d/],
			pipe: textMaskAddons.createAutoCorrectedDatePipe('dd.mm.yyyy')
		});
		//Телефон абитуриента
		vanillaTextMask.maskInput({
			inputElement: $('#phone_abit')[0],
			mask: ['(', /[1-10]/, /\d/, /\d/, ')', ' ', /\d/, /\d/, /\d/, '-', /\d/, /\d/, /\d/, /\d/]
		});
		vanillaTextMask.maskInput({
			inputElement: $('#phone_mother')[0],
			mask: ['(', /[1-10]/, /\d/, /\d/, ')', ' ', /\d/, /\d/, /\d/, '-', /\d/, /\d/, /\d/, /\d/]
		});
		vanillaTextMask.maskInput({
			inputElement: $('#phone_father')[0],
			mask: ['(', /[1-10]/, /\d/, /\d/, ')', ' ', /\d/, /\d/, /\d/, '-', /\d/, /\d/, /\d/, /\d/]
		});

		function show (box) {
			var vis = (box.checked) ? "none" : "block";
			document.getElementById('fact').style.display = vis;
		}
		function del (id) {
			if (id != 0)
            {
                let form = document.createElement('form');
				var al = $('#active_list').val();
                form.action = '/sert/del';
                form.method = 'POST';
                form.innerHTML = '<input name="serid" value="' + id + '"><input name="active_list" value="' + al + '">{{ csrf_field() }}';
                document.body.append(form);
                form.submit();
            }
		}
		function select_zno(type_sertificate,ser_sert,num_sert,predmet_id,ball_sert,date_sert)
		{
			//$('#type_sertificate').val(type_sertificate);
			$("#type_sertificate option[value=" + type_sertificate + "]").attr('selected', 'true')
			$('#ser_sert').val(ser_sert);
			$('#num_sert').val(num_sert);
			$('#pred_name').val(predmet_id);
			$('#ball_sert').val(ball_sert);
			$('#date_sert').val(date_sert);
		}




	</script>
@endsection

@section('content')
	<h4 class="font-weight-bold py-3 mb-4">
		Личная карточка
	</h4>
	<form action="/profilesave" method="POST" enctype="multipart/form-data">
		{{ csrf_field() }}
		<input type="hidden" name="pid" value='{{ isset($person) ? $person->id : -1  }}'>
		<input type="hidden" id="active_list" name="active_list" value="{{ Session::has('active_list') ? Session::get('active_list') : '' }}">
		<div class="card overflow-hidden">
			<div class="row no-gutters row-bordered row-border-light">
				<div class="col-md-3 pt-0">
					<div class="list-group list-group-flush account-settings-links">
						<a onclick="$('#active_list').val('info-main');"           class="list-group-item list-group-item-action {{ Session::has('active_list') ? Session::get('active_list') == 'info-main' ? 'active' : '' : 'active' }}" data-toggle="list" href="#info-main">Основная информация</a>
						<a onclick="$('#active_list').val('info-registration');"   class="list-group-item list-group-item-action {{ Session::has('active_list') ? Session::get('active_list') == 'info-registration' ? 'active' : '' : '' }}" data-toggle="list" href="#info-registration">Прописка</a>
						<a onclick="$('#active_list').val('info-pasport');"        class="list-group-item list-group-item-action {{ Session::has('active_list') ? Session::get('active_list') == 'info-pasport' ? 'active' : '' : '' }}" data-toggle="list" href="#info-pasport">Паспортные данные</a>
						<a onclick="$('#active_list').val('info-education');"      class="list-group-item list-group-item-action {{ Session::has('active_list') ? Session::get('active_list') == 'info-education' ? 'active' : '' : '' }}" data-toggle="list" href="#info-education">Документы об образовании</a>
						<a onclick="$('#active_list').val('info-famaly');"         class="list-group-item list-group-item-action {{ Session::has('active_list') ? Session::get('active_list') == 'info-famaly' ? 'active' : '' : '' }}" data-toggle="list" href="#info-famaly">Информация о родителях</a>
						<a onclick="$('#active_list').val('info-ball');"           class="list-group-item list-group-item-action {{ Session::has('active_list') ? Session::get('active_list') == 'info-ball' ? 'active' : '' : '' }}" data-toggle="list" href="#info-ball">Результаты ЕГЭ/ВНО</a>
						<!--<a onclick="$('#active_list').val('info-ball');"           class="list-group-item list-group-item-action {{ Session::has('active_list') ? Session::get('active_list') == 'info-ball' ? 'active' : '' : '' }}" data-toggle="list" href="#info-photo">Фотографии документом</a> -->
					</div>
				</div>
				<div class="col-md-9">
					<div class="tab-content">
						<!-- 1 -->
						<div class="tab-pane fade {{ Session::has('active_list') ? Session::get('active_list') == 'info-main' ? 'show active' : '' : 'show active' }}" id="info-main">
							<div class="card-body pb-2">
								<div class="form-group">
									<label class="form-label">Фамилия
										<span class="text-danger">*</span>
									</label>
									<input name="FirstName" type="text" class="form-control " value="{{ isset($person) ? $person->famil : '' }}" >
								</div>
								<div class="form-group">
									<label class="form-label">Имя
										<span class="text-danger">*</span>
									</label>
									<input name="Name" type="text" class="form-control " value="{{ isset($person) ? $person->name : ''  }}" >
								</div>
								<div class="form-group">
									<label class="form-label">Отчество
										<span class="text-danger">*</span>
									</label>
									<input name="LastName" type="text" class="form-control " value="{{ isset($person) ? $person->otch : ''  }}" >
								</div>
								<div class="row">
									<div class="col">
										<div class="form-group">
											<label class="form-label">Дата рождения
												<span class="text-danger">*</span>
											</label>
											<input type="text" id="date_birth" name="birthday" class="form-control " placeholder="__.__.____"  value="{{ isset($person) ? date('d.m.Y', strtotime($person->birthday)) : '' }}" >
										</div>
									</div>
									<div class="col">
										<div class="form-group">
											<label class="form-label">Пол
												<span class="text-danger">*</span>
											</label>
											<select class="selectpicker show-tick form-control " data-style="btn-default" data-icon-base="ion" data-tick-icon="ion-md-checkmark"  name="gender" >
												<option value="Муж" {{ isset($person) ? $person->gender == "Муж" ? "selected" : "" : ''}}>Мужчина</option>
												<option value="Жен" {{ isset($person) ? $person->gender == "Жен" ? "selected" : "" : ''}}>Женщина</option>
											</select>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col">
										<div class="form-group">
											<label class="form-label">Номер телефона
												<span class="text-danger">*</span>
											</label>
											<input type="text" id="phone_abit" name="phone_one" class="form-control " placeholder="(___) ___-_____" value="{{ isset($person) ? $person->phone_one : '' }}" >
										</div>
									</div>
									<div class="col">
										<div class="form-group">
											<label class="form-label">Второй номер телефона</label>
											<input type="text" id="phone_abit" name="phone_two" class="form-control " placeholder="(___) ___-_____" value="{{ isset($person) ? $person->phone_two : ''}}">
										</div>
									</div>
									<div class="col">
										<div class="form-group">
											<label class="form-label">E-mail</label>
											<input type="text" id="email_abit" name="email_abit" class="form-control " placeholder="noreply@gmail.com" value="{{ isset($person) ? $person->email : ''}}">
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col">
										<div class="form-group">
											<label class="form-label">Гражданство</label>
											<select class="selectpicker show-tick form-control " data-style="btn-default" data-icon-base="ion" data-tick-icon="ion-md-checkmark" name="citizen">
												<option value="LNR" {{ isset($person) ? $person->citizen == "LNR" ? "selected" : "" : '' }}>ЛНР</option>
												<option value="DNR" {{ isset($person) ? $person->citizen == "DNR" ? "selected" : "" : ''}}>ДНР</option>
												<option value="UA" {{ isset($person) ? $person->citizen == "UA" ? "selected" : "" : ''}}>Украина</option>
												<option value="RU" {{ isset($person) ? $person->citizen == "RU" ? "selected" : "" : ''}}>Россия</option>
											</select>
										</div>
									</div>
									<div class="col">
										<div class="form-group">
											<label class="form-label">Владение языками</label>
											<select class="selectpicker" data-style="btn-default" multiple data-icon-base="ion" data-tick-icon="ion-md-checkmark" name="language[]">
												<option value="EN" {{ isset($person) ? $person->english_lang == 'T' ? 'selected' : '' : ''}}>Английский</option>
												<option value="FR" {{ isset($person) ? $person->franch_lang  == 'T' ? 'selected' : '' : ''}}>Французский</option>
												<option value="GE" {{ isset($person) ? $person->deutsch_lang == 'T' ? 'selected' : '' : ''}}>Немецкий</option>
											</select>
										</div>
									</div>
								</div>
								<div class="form-group">
									<label class="form-label">Тип льготы
										<span class="text-danger">*</span>
									</label>
									<select class="selectpicker" data-style="btn-default" multiple data-icon-base="ion" data-tick-icon="ion-md-checkmark" name="type_priv[]">
										@foreach ($privileges as $type)
											<option value="{{ $type->id }}" {{ isset($pers_privilage[$type->id]) ? 'selected' : '' }}>{{ $type->name }}</option>
										@endforeach
									</select>
								</div>
								<div class="form-group">
									<label class="custom-control custom-checkbox">
										<input type="checkbox" class="custom-control-input" value="1" name="hostel_need" {{ isset($person) ? $person->hostel_need == '1' ? 'checked' : '' : ''}}>
										<span class="custom-control-label">Требуется общежитие</span>
									</label>
								</div>
							</div>
						</div>

						<!-- 2 -->
						<div class="tab-pane fade {{ Session::has('active_list') ? Session::get('active_list') == 'info-registration' ? 'show active' : '' : '' }}" id="info-registration">
							<div class="card-body pb-2">
								<div class="form-group">
									<label class="form-label">Государство
										<span class="text-danger">*</span>
									</label>
									<input name="country" type="text" class="form-control " value="{{ isset($person) ? $person->country : '' }}" >
								</div>
								<div class="form-group">
									<label class="form-label">Обсласть
										<span class="text-danger">*</span>
									</label>
									<input name="adr_obl" type="text" class="form-control " value="{{ isset($person) ? $person->adr_obl : '' }}" >
								</div>
								<div class="form-group">
									<label class="form-label">Район
										<span class="text-danger">*</span>
									</label>
									<input name="adr_rajon" type="text" class="form-control " value="{{ isset($person) ? $person->adr_rajon : '' }}" >
								</div>
								<div class="form-group">
									<label class="form-label">Город
										<span class="text-danger">*</span>
									</label>
									<input name="adr_city" type="text" class="form-control " value="{{ isset($person) ? $person->adr_city : '' }}" >
								</div>
								<div class="form-group">
									<label class="form-label">Улица
										<span class="text-danger">*</span>
									</label>
									<input name="adr_street" type="text" class="form-control " value="{{ isset($person) ? $person->adr_street : '' }}" >
								</div>
								<div class="row">
									<div class="col">
										<div class="form-group">
											<label class="form-label">Дом</label>
											<input type="text" name="adr_house" class="form-control " value="{{ isset($person) ? $person->adr_house : '' }}">
										</div>
									</div>
									<div class="col">
										<div class="form-group">
											<label class="form-label">Квартира</label>
											<input type="text" name="adr_flatroom" class="form-control " value="{{ isset($person) ? $person->adr_flatroom : '' }}">
										</div>
									</div>
								</div>
								<label class="custom-control custom-checkbox">
									<input type="checkbox" class="custom-control-input" onclick="show(this)">
									<span class="custom-control-label">Прописка совпадает с фактическим местом проживания</span>
								</label>
								<div class="form-group" id="fact">
									<label class="form-label">Фактическое проживание</label>
									<input name="fact_residence" type="text" class="form-control " value="{{ isset($person) ? $person->fact_residence : '' }}" >
								</div>
							</div>
						</div>

						<!-- 3 -->
						<div class="tab-pane fade {{ Session::has('active_list') ? Session::get('active_list') == 'info-pasport' ? 'show active' : '' : '' }}" id="info-pasport">
							<div class="card-body pb-2">
								<div class="row">
									<div class="col">
										<div class="form-group">
											<label class="form-label">Тип документа
												<span class="text-danger">*</span>
											</label>
											<select class="selectpicker show-tick form-control " data-style="btn-default" data-icon-base="ion" data-tick-icon="ion-md-checkmark" name="type_doc" >
												<option value="Паспорт" {{ isset($person) ? $person->type_doc == "Паспорт" ? "selected" : "" : ''}}>Паспорт</option>
												<option value="Свидетельство" {{ isset($person) ? $person->type_doc == "Свидетельство" ? "selected" : "" : ''}}>Свидетельство</option>
											</select>
										</div>
									</div>
									<div class="col">
										<div class="form-group">
											<label class="form-label">Дата выдачи
												<span class="text-danger">*</span>
											</label>
											<input name="pasp_date" id="date_vidach" type="text" class="form-control " placeholder="__.__.____" value="{{ isset($person) ? date('d.m.Y', strtotime($person->pasp_date)) : ''}}" >
										</div>
									</div>
									<div class="col">
										<div class="form-group">
											<label class="form-label">Идентификационный код
												<span class="text-danger">*</span>
											</label>
											<input name="indkod" id="mask-number" type="text" class="form-control " value="{{ isset($person) ? $person->indkod : ''}}" >
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col">
										<div class="form-group">
											<label class="form-label">Серия документа
												<span class="text-danger">*</span>
											</label>
											<input name="pasp_ser" type="text" class="form-control " value="{{ isset($person) ? $person->pasp_ser : ''}}">
										</div>
									</div>
									<div class="col">
										<div class="form-group">
											<label class="form-label">Номер документа
												<span class="text-danger">*</span>
											</label>
											<input name="pasp_num" type="text" class="form-control " value="{{ isset($person) ? $person->pasp_num : ''}}">
										</div>
									</div>
								</div>
								<div class="form-group">
									<label class="form-label">Где и кем выдан документ
										<span class="text-danger">*</span>
									</label>
									<input name="pasp_vid" type="text" class="form-control " value="{{ isset($person) ? $person->pasp_vid : ''}}">
								</div>
							</div>
						</div>

						<!-- 4 -->
						<div class="tab-pane fade {{ Session::has('active_list') ? Session::get('active_list') == 'info-education' ? 'show active' : '' : '' }}" id="info-education">
							<div class="card-body pb-2">
								<div class="form-group">
									<label class="form-label">Образовательный уровень
										<span class="text-danger">*</span>
									</label>
									<input type="hidden" name="adid" value="{{ isset($doc_pers) ? $doc_pers->id : '-1' }}">
									<select class="selectpicker show-tick form-control " data-style="btn-default" data-icon-base="ion" data-tick-icon="ion-md-checkmark" name="typeEducation">
										@foreach ($typeEducation as $te)
											<option value="{{ $te->id }}" {{ isset($doc_pers) ? $te->id == $doc_pers->educ_id ? 'selected' : '' : ''}}>{{ $te->name }}</option>	
										@endforeach
									</select>
								</div>
								<div class="form-group">
									<label class="form-label">Учебное заведение
										<span class="text-danger">*</span>
									</label>
									<input  type="text" class="form-control" name="uch_zav" value="{{ isset($doc_pers) ? $doc_pers->uch_zav : '' }}">
								</div>

								<div class="form-group">
									<label class="form-label">Док-то об образовании</label>
									<select class="selectpicker show-tick form-control " data-style="btn-default" data-icon-base="ion" data-tick-icon="ion-md-checkmark" name="doc_id">
										<option value="1" {{ isset($doc_pers) ? $doc_pers->doc_id == 1 ? 'selected' : '' : '' }}>Аттестат</option>
										<option value="7" {{ isset($doc_pers) ? $doc_pers->doc_id == 7 ? 'selected' : '' : '' }}>Диплом</option>
									</select>
								</div>

								<div class="row">
									<div class="col">
										<label class="form-label">Дата выдачи</label>
										<input type="text" id="date_vidach_doc"  class="form-control " placeholder="__.__.____" name="doc_date" value="{{ isset($doc_pers) ? date('d.m.Y', strtotime($doc_pers->doc_date)) : '' }}">
									</div>
								</div>
								<div class="row">
									<div class="col">
										<div class="form-group">
											<label class="form-label">Серия документа</label>
											<input type="text"  class="form-control " name="doc_ser" value="{{ isset($doc_pers) ? $doc_pers->doc_ser : '' }}">
										</div>
									</div>
									<div class="col">
										<div class="form-group">
											<label class="form-label">Номер документа</label>
											<input type="text"  class="form-control " name="doc_num" value="{{ isset($doc_pers) ? $doc_pers->doc_num : '' }}">
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col">
										<div class="form-group">
											<label class="form-label">Серия и номер приложения</label>
											<input type="text" class="form-control " name="app_num" value="{{ isset($doc_pers) ? $doc_pers->app_num : '' }}">
										</div>
									</div>
									<div class="col">
										<div class="form-group">
											<label class="form-label">Средний балл</label>
											<input type="text"  class="form-control " name="sr_bal" value="{{ isset($doc_pers) ? $doc_pers->sr_bal : '' }}">
										</div>
									</div>
								</div>
								<div class="form-group">
									<label class="form-label">Кем выдан документ
										<span class="text-danger">*</span>
									</label>
									<input type="text" class="form-control" name="doc_vidan" value="{{ isset($doc_pers) ? $doc_pers->doc_vidan : '' }}">
								</div>
							</div>
						</div>

						<!-- 5 -->
						<div class="tab-pane fade {{ Session::has('active_list') ? Session::get('active_list') == 'info-famaly' ? 'show active' : '' : '' }}" id="info-famaly">
							<div class="card-body pb-2">
								<div class="form-row">
									<div class="form-group col-md-4">
										<label class="form-label">ФИО (Отца)</label>
										<input type="text" class="form-control" name="father_name" value="{{ isset($person) ? $person->father_name : ''}}">
									</div>
									<div class="form-group col-md-3">
										<label class="form-label">Номер телефона (Отца)</label>
										<input type="text" id="phone_father" name="father_phone" class="form-control" placeholder="__.__.____" value="{{ isset($person) ? $person->father_phone  : ''}}">
									</div>
								</div>
								<div class="form-row">
									<div class="form-group col-md-4">
										<label class="form-label">ФИО (Матери)</label>
										<input type="text" class="form-control" name="mother_name" value="{{ isset($person) ? $person->mother_name : ''}}">
									</div>
									<div class="form-group col-md-3">
										<label class="form-label">Номер телефона (Матери)</label>
										<input type="text" id="phone_mother" name="mother_phone" class="form-control" placeholder="__.__.____"value="{{ isset($person) ? $person->mother_phone: ''}}">
									</div>
								</div>
							</div>
						</div>

						<!-- 6 -->
						<div class="tab-pane fade {{ Session::has('active_list') ? Session::get('active_list') == 'info-ball' ? 'show active' : '' : '' }}" id="info-ball">
							<div class="card-body pb-2">
								<div class="col">
									<div class="form-row">
										<div class="form-group col-md-4">
											<label class="form-label">Тип сертификата</label>
											<select class="selectpicker show-tick form-control" data-style="btn-default" data-icon-base="ion" data-tick-icon="ion-md-checkmark" name="zno_type" id="type_sertificate">
												<option value="ЕГЭ">ЕГЭ</option>
												<option value="ВНО">ВНО</option>
												<option value="ГИА">ГИА</option>
											</select>
										</div>
										<div class="form-group col-md-4">
											<label class="form-label">Предмет</label>
											<select class="selectpicker show-tick form-control " data-style="btn-default" data-icon-base="ion" data-tick-icon="ion-md-checkmark" name="zno_id" id="pred_name">
												@foreach ($predmet_zno as $zno)
													<option value="{{ $zno->id }}">{{ $zno->name }}</option>
												@endforeach
											</select>
										</div>
										<div class="form-group col-md-4">
											<label class="form-label">Балл</label>
											<input type="text" class="form-control required" name="zno_ball" id="ball_sert">
										</div>
									</div>
									<div class="form-row">
										<div class="form-group col-md-4">
											<label class="form-label">Серия</label>
											<input type="text" class="form-control required" name="zno_ser" id="ser_sert">
										</div>
										<div class="form-group col-md-4">
											<label class="form-label">Номер</label>
											<input type="text" class="form-control required" name="zno_num" id="num_sert">
										</div>
										<div class="form-group col-md-4">
											<label class="form-label">Дата выдачи</label>
											<input type="text" placeholder="__.__.____" class="form-control required" name="zno_date" id="date_sert">
										</div>
									</div>
									<div class="form-group">
										<label class="form-label">Кем выдан</label>
										<input type="text" class="form-control" name="zno_vidan">
									</div>
								</div>
								<div class="col">
									<table class="table table-hover" style="cursor: default;">
										<thead>
											<tr>
												<th class="text-center">№</th>
												<th class="text-center">Тип</th>
												<th class="text-center">Серия и номер</th>
												<th class="text-center">Предмет</th>
												<th class="text-center">Балл</th>
												<th class="text-center">Дата</th>
												<th class="text-center">Удалить</th>
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
															<td class="text-center"><span onclick="del({{ $pz->id }})" class="text-danger" style="cursor: pointer;">X</span></td>
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
		<div class="text-right mt-3">
			<button type="submit" class="btn btn-primary">Сохранить</button>&nbsp;
			<!--<button type="submit" class="btn btn-default">Выход</button> -->
		</div>
	</form>
@endsection

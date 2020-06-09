@extends('layout.layout-2')

@section('styles')
	<!-- Page -->
	<link rel="stylesheet" href="{{ asset('assets/vendor/css/pages/users.css') }}">
	<link href="{{ asset('fonts/fonts/font-awesome.min.css') }}" rel="stylesheet">
	<link href="{{ asset('css/toastr.min.css') }}" rel="stylesheet">
@endsection

@section('scripts')
	<script src="{{ asset('js/toastr.min.js') }}"></script>
	<script src="{{ asset('js/profile.js') }}"></script>
@endsection

@section('content')
	<div class="media align-items-center py-3 mb-3">
		<img src="{{ $person->photo_url }}" alt="" class="d-block ui-w-100 rounded-circle" id="photo_main">
		<div class="media-body ml-4">
			<h4 class="font-weight-bold mb-0">{{ $person->famil.' '.$person->name.' '.$person->otch }}</h4>
			<div class="text-muted mb-2">E-mail: {{ $person->email }}</div>
			<a href="javascript:void(0)" class="btn btn-primary btn-sm" onclick="FindFile();"><i class="ion ion-md-photos"></i> Фото</a>
			<form action="#" method="POST" enctype="multipart/form-data" id="loadPhoto" style="position:absolute;overflow: hidden;display:block;height:0px;width:0px;">
				<input type="file"   id="FindFile" accept="image/jpeg,image/png,image/gif" name="FindFile" onchange="LoadFile();" style="display: none">
				<input type="hidden" name="pid" value="{{ $person->id }}">
				<input type="submit" id="loadFile" style="display: none" value='Загрузить'>
			</form>
			<iframe id="rFrame" name="rFrame" style="display: none"> </iframe>
			<a href="{{ url('/insert_abit') }}" class="btn btn-default btn-sm"><i class="ion ion-md-person "></i> Данные</a>
			<a href="{{ url('/scanPhoto') }}" class="btn btn-default btn-sm"><i class="ion ion-md-images "></i> Скан фото</a>
			<div class="demo-paragraph-spacing mt-3">
				<a href="{{ url('/success_insert_abit') }}" class="btn btn-primary"><i class="ion ion-md-add"></i> Добавить заявление</a>
			</div>
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
				<tr>
					<td>Количество фотографий:</td>
					<td><span class="badge badge-outline-success">{{ $person->count_photo }}</span></td>
				</tr>
				<tr>
					<td>Оригинал документов:</td>
					<td><span class="badge badge-outline-danger">{{ $person->is_orig == 'T' ? 'Да' : 'Нет' }}</span></td>
				</tr>
				</tbody>
			</table>
		</div>
		<hr class="border-light m-0">
		<!-- bootstrap сыпится ((
		<div class="card mb-2">
			<div class="card-header">
				<a class="collapsed text-body d-flex justify-content-between" data-toggle="collapse" href="#accordion2-2">
					Collapsible Group Item #2
					<div class="collapse-icon"></div>
				</a>
			</div>
			<div id="accordion2-2" class="collapse" data-parent="#accordion2">
				<div class="card-body">
					Какая-то информация
				</div>
			</div>
		</div> -->

		<div class="table-responsive">
			<table class="table card-table m-0">
				<thead>
					<tr>
						<th class="align-middle">Институт / факультет</th>
						<th class="align-middle">Направление</th>
						<th class="align-middle">Шифр</th>
						<th class="align-right">Форма обучения</th>
						<th class="align-right">Возврат</th>
					</tr>
				</thead>
				<tbody>
					@if(count($person_statement) > 0)
						@foreach ($person_statement as $ps)
							<tr>
								<td class="align-middle">{{ $ps->fac_name }}</td>
								<td class="align-middle">{{ $ps->spec_name }}</td>
								<td class="align-middle">{{ $ps->shifr_statement }}</td>
								<td class="align-middle">{{ $ps->form_obuch }}</td>
								<td>{{ $ps->date_return == null ? '<span class="ion ion-md-close text-light"></span>' : '<span class="ion ion-md-checkmark text-primary"></span>' }}</td>
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
						<li class="nav-item">
							<a class="nav-link active" data-toggle="tab" href="#navs-top-info" style="">Основная информация</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" data-toggle="tab" href="#navs-top-passport" style="">Паспортные данные</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" data-toggle="tab" href="#navs-top-parents" style="">Информация о родителях</a>
						</li>
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
									<input type="text" class="form-control" placeholder="12.12.1999" value="{{ $person->birthday }}" disabled="true">
								</div>
								<div class="form-group col-md-2">
									<label class="form-label">Пол</label>
									<input type="text" class="form-control" placeholder="Мужской" value="{{ $person->gender == "Муж" ? "Мужской" : $person->gender == "Жен" ? "Женский" : ""}}" disabled="true">
								</div>
							</div>
							<div class="form-row">
								<div class="form-group col-md-2">
									<label class="form-label">Страна</label>
									<input type="text" class="form-control" placeholder="ЛНР" value="{{$person->country}}" disabled="true">
								</div>
								<div class="form-group col-md-2">
									<label class="form-label">Область/Регион</label>
									<input type="text" class="form-control" placeholder="Луганская область" value="{{$person->adr_obl}}" disabled="true">
								</div>
								<div class="form-group col-md-2">
									<label class="form-label">Район</label>
									<input type="text" class="form-control" placeholder="Краснодонский район" value="{{$person->adr_rajon}}" disabled="true">
								</div>
								<div class="form-group col-md-2">
									<label class="form-label">Населенный пункт</label>
									<input type="text" class="form-control" placeholder="г. Краснодон" value="{{$person->adr_city}}" disabled="true">
								</div>
								<div class="form-group col-md-2">
									<label class="form-label">Улица</label>
									<input type="text" class="form-control" placeholder="ул. Ленина" value="{{$person->adr_street}}" disabled="true">
								</div>
							</div>
							<div class="form-row">
								<div class="form-group col-md-2">
									<label class="form-label">Дом</label>
									<input type="text" class="form-control" placeholder="15" value="{{$person->adr_house}}" disabled="true">
								</div>
								<div class="form-group col-md-2">
									<label class="form-label">Квартира</label>
									<input type="text" class="form-control" placeholder="75" value="{{$person->adr_flatroom}}" disabled="true">
								</div>
								<div class="form-group col-md-6">
									<label class="form-label">Адрес фактического проживания</label>
									<input type="text" class="form-control" placeholder="1234 Main St" disabled="true">
								</div>
							</div>
							<div class="form-row">

								<div class="form-group col-md-2">
									<label class="form-label">Номер телефона 1</label>
									<input type="text" class="form-control" placeholder="+38 (072) 123 456 7" value="{{$person->phone_one}}" disabled="true">
								</div>
								<div class="form-group col-md-2">
									<label class="form-label">Номер телефона 2</label>
									<input type="text" class="form-control" placeholder="+38 (072) 123 456 7" value="{{$person->phone_two}}" disabled="true">
								</div>
								<div class="form-group col-md-6">
									<label class="form-label">Владение языками</label>
									<input type="text" class="form-control" placeholder="Ангийский, Немецкий ..." value="{{$person->english_lang == 'T' ? 'Английский ' : '' }}{{$person->franch_lang == 'T' ? 'Фанцузский ' : '' }}{{$person->deutsch_lang == 'T' ? 'Немецкий ' : '' }}{{$person->other_lang != '' ? $person->other_lang : '' }}" disabled="true">
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
								<div class="form-group col-md-1">
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
								<div class="form-group col-md-5">
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
				</div>
			</div>
		</div>
	</div>
@endsection
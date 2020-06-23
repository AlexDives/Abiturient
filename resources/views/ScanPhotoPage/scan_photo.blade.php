@extends('layout.layout-2')

@section('styles')
	<link rel="stylesheet" href="{{ asset('assets/vendor/libs/bootstrap-select/bootstrap-select.css') }}">
	<link rel="stylesheet" href="{{ asset('assets/vendor/libs/bootstrap-tagsinput/bootstrap-tagsinput.css') }}">
	<link rel="stylesheet" href="{{ asset('assets/vendor/libs/dropzone/dropzone.css')}}">
	<link rel="stylesheet" href="{{ asset('css/style.css')}}">
@endsection

@section('scripts')
	<!-- Dependencies -->
	<script src="{{ asset('assets/vendor/libs/bootstrap-select/bootstrap-select.js') }}"></script>
	<script src="{{ asset('assets/vendor/libs/bootstrap-tagsinput/bootstrap-tagsinput.js') }}"></script>
	<script src="{{asset('assets/vendor/libs/dropzone/dropzone.min.js')}}"></script>
	 <script type="text/javascript">
		 // Immediately after the js include
		 Dropzone.autoDiscover = false;
		</script>
@endsection

@section('content')
	<h4 class="font-weight-bold py-3 mb-4">
		Загрузка скан-копий документов
	</h4>
	<div class="card mb-4">
		<h6 class="card-header">
			Выбор скан-копий
		</h6>
		<div class="card-body">
			<div class="cui-example">
				<div class="form-group">
					<label class="form-label">Укажите список сканй-копий которые вы хотите загрузиить</label>
					<select class="selectpicker" id="slct_typ_doc" data-style="btn-default" multiple data-icon-base="ion" data-tick-icon="ion-md-checkmark" name="language[]">
						@foreach($typDoc as $t)
							<option value="{{$t->id}}">{{$t->name}}</option>
						@endforeach
					</select>
				</div>
				<div>
					<form  class="dropzone needsclick" id="dropzone-demo">
						<div class="dz-message needsclick">
							Нажмите чтобы выбрать файл
							<span class="note needsclick">(Здесь будут отображены ваши скан-копии)</span>
						</div>
						<div class="fallback">
							<input name="file" type="file"  multiple>
						</div>
					</form>
				</div>
				<!-- Javascript -->
				<script>
					$(function() {
						$('#dropzone-demo').dropzone({
							addRemoveLinks: true,
							autoProcessQueue: false,
							uploadMultiple: true,
							parallelUploads: 100,
							maxFiles: 15,
							paramName: 'file',
							acceptedFiles: ".jpeg,.jpg,.png,.gif,.pdf",
							clickable: true,
							url: '/upload_scan_photo',
							init: function () {
								var CSRF_TOKEN = document.querySelector('meta[name="csrf-token"]').getAttribute("content");
								var self = this;
								$('#scan_btn').click(function (e) {
									e.preventDefault();
										self.processQueue();
									return false;
								});

								self.on('sending', function (file, xhr, formData) {
									// Append all form inputs to the formData Dropzone will POST
									var data = $('#dropzone-demo').serializeArray();
									formData.append("_token", CSRF_TOKEN);
									formData.append("typ_doc", $('#slct_typ_doc').val());
									$.each(data, function (key, el) {
										formData.append(el.name, el.value);
									});
									for(var pair of formData.entries()) {
										console.log(pair[0]+ ', '+ pair[1]);
									}
								});
								self.on("success", function(first,response) {
					    $('.scan_suc_msg').text('Документы успешно отсканированны!');
					  });
							},
						});
					});
				</script>
				<!-- / Javascript -->
			</div>
		</div>
	</div>
	<div class="scan-card-footer">
		<span class="scan_suc_msg"></span>
		<span>
		<input type="submit" class="btn btn-primary" id="scan_btn" value="Отправить скан-копии">
		<button class="btn btn-primary" value=""><a href="/profile" style="color:White">Назад</a></button>
		</span>
	</div>

@endsection

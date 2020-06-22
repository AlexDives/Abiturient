@extends('layout.layout-2')

@section('styles')
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/bootstrap-select/bootstrap-select.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/bootstrap-tagsinput/bootstrap-tagsinput.css') }}">
    <!-- Page -->
    <link rel="stylesheet" href="{{ asset('assets/vendor/css/pages/account.css') }}">
@endsection

@section('scripts')
    <!-- Dependencies -->
    <script src="{{ asset('assets/vendor/libs/bootstrap-select/bootstrap-select.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/bootstrap-tagsinput/bootstrap-tagsinput.js') }}"></script>
    <script>
        function fill_facult()
        {
            var bid = $('#abit_branch').val();
            $.ajax({
                url: '/statement/get_facultet',
                method: 'post',
                data: { bid : bid },
                headers: {
                    'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(data) {
                    $('#abit_facultet').html(data);
                },
                error: function(msg) {
                    $('#abit_facultet').html(msg.responseText);
                }
            });
            $('#abit_stlevel').html('<option>Выберите элемент</option>');
            $('#abit_formobuch').html('<option>Выберите элемент</option>');
            $('#abit_group').html('<option>Выберите элемент</option>');
        }
        
        function fill_stlevel()
        {
            var fkid = $('#abit_facultet').val();
            $.ajax({
                url: '/statement/get_stlevel',
                method: 'post',
                data: { fkid : fkid },
                headers: {
                    'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(data) {
                    $('#abit_stlevel').html(data);
                },
                error: function(msg) {
                    $('#abit_stlevel').html(msg.responseText);
                }
            });
            $('#abit_formobuch').html('<option>Выберите элемент</option>');
            $('#abit_group').html('<option>Выберите элемент</option>');
        }

        function fill_formobuch()
        {
            var fkid = $('#abit_facultet').val();
            var stid = $('#abit_stlevel').val();
            $.ajax({
                url: '/statement/get_form_obuch',
                method: 'post',
                data: { fkid : fkid, stid : stid },
                headers: {
                    'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(data) {
                    $('#abit_formobuch').html(data);
                },
                error: function(msg) {
                    $('#abit_formobuch').html(msg.responseText);
                }
            });
            $('#abit_group').html('<option>Выберите элемент</option>');
        }

        function fill_group()
        {
            var fkid = $('#abit_facultet').val();
            var stid = $('#abit_stlevel').val();
            var foid = $('#abit_formobuch').val();
            var pid = $('#pid').val();
            $.ajax({
                url: '/statement/get_group',
                method: 'post',
                data: { 
                    fkid : fkid, 
                    stid : stid, 
                    foid : foid, 
                    pid  : pid 
                },
                headers: {
                    'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(data) {
                    $('#abit_group').html(data);
                },
                error: function(msg) {
                    $('#abit_group').html(msg.responseText);
                }
            });
        }
    </script>
@endsection

@section('content')
    <h4 class="font-weight-bold py-3 mb-4">
        Личная карточка
    </h4>
    <form action="/statement/create" method="POST" enctype="multipart/form-data">
        {{ csrf_field() }}
        <input type="hidden" name="pid" id="pid" value="{{ $person_id }}">
        <div class="card overflow-hidden">
            <div class="row no-gutters row-bordered row-border-light">
                <div class="col-md-3 pt-0">
                    <div class="list-group list-group-flush account-settings-links">
                        <a class="list-group-item list-group-item-action active" data-toggle="list" href="#main-card">Выбор направления</a>
                    </div>
                </div>
                <div class="col-md-9">
                    <div class="tab-content">
                        <!-- 1 -->
                        <div class="tab-pane fade show active" id="main-card">
                            <div class="card-body">
                                <div class="form-group">
                                    <label class="form-label">Образовательная организация
                                        <span class="text-danger">*</span>
                                    </label>
                                    <select id="abit_branch" name="abit_branch" onchange="fill_facult();" class="form-control" data-style="btn-default" data-icon-base="ion" data-tick-icon="ion-md-checkmark" >
                                        <option>Выберите элемент</option>
                                        @foreach ($abit_branch as $ab)
                                            <option value="{{ $ab->id }}">{{ $ab->short_name }}</option>    
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Институт/Факультет
                                        <span class="text-danger">*</span>
                                    </label>
                                    <select id="abit_facultet" name="abit_facultet" onchange="fill_stlevel();" class="form-control " data-style="btn-default" data-icon-base="ion" data-tick-icon="ion-md-checkmark">
                                        <option>Выберите элемент</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Образовательный уровень
                                        <span class="text-danger">*</span>
                                    </label>
                                    <select id="abit_stlevel" name="abit_stlevel" onchange="fill_formobuch();" class="form-control " data-style="btn-default" data-icon-base="ion" data-tick-icon="ion-md-checkmark" >
                                        <option>Выберите элемент</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Форма обучения
                                        <span class="text-danger">*</span>
                                    </label>
                                    <select id="abit_formobuch" name="abit_formobuch" onchange="fill_group();" class="form-control " data-style="btn-default" data-icon-base="ion" data-tick-icon="ion-md-checkmark" >
                                        <option>Выберите элемент</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Специальность
                                        <span class="text-danger">*</span>
                                    </label>
                                    <select id="abit_group" name="abit_group" class="form-control " data-style="btn-default" data-icon-base="ion" data-tick-icon="ion-md-checkmark">
                                        <option>Выберите элемент</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

            </div>

        </div>
        <div class="text-right mt-3">
            <button type="submit" class="btn btn-primary">Сохранить</button>&nbsp;
        </div>
    </form>
@endsection

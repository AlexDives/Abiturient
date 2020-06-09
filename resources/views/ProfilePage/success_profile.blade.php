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
@endsection

@section('content')
    <h4 class="font-weight-bold py-3 mb-4">
        Личная карточка
    </h4>
    <form action="/profilesfgd" method="POST" enctype="multipart/form-data">
        {{ csrf_field() }}
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
                                    <label class="form-label">Выбор филиала
                                        <span class="text-danger">*</span>
                                    </label>
                                    <select class="selectpicker show-tick form-control " data-style="btn-default" data-icon-base="ion" data-tick-icon="ion-md-checkmark" >
                                        <option></option>
                                        <option value="1">Луганский государственный университет им. Тараса Шевченко</option>
                                        <option value="2">Ровеньковский факультет</option>
                                        <option value="3">СПК ЛНУ им. Тараса Шевченко</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Форма обучения
                                        <span class="text-danger">*</span>
                                    </label>
                                    <select class="selectpicker show-tick form-control " data-style="btn-default" data-icon-base="ion" data-tick-icon="ion-md-checkmark" >
                                        <option></option>
                                        <option value="1">Очное</option>
                                        <option value="2">Заочное</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Институт/Факультет
                                        <span class="text-danger">*</span>
                                    </label>
                                    <select class="selectpicker show-tick form-control " data-style="btn-default" data-icon-base="ion" data-tick-icon="ion-md-checkmark">
                                        <option></option>
                                        <option value="1">ИФМИТ</option>
                                        <option value="2">ИПП</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Специальность
                                        <span class="text-danger">*</span>
                                    </label>
                                    <select class="selectpicker show-tick form-control " data-style="btn-default" data-icon-base="ion" data-tick-icon="ion-md-checkmark">
                                        <option value="1101">Программная инженерия</option>
                                        <option value="1110">Информатика</option>
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

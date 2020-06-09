@extends('layout.layout-2')

@section('styles')
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/bootstrap-select/bootstrap-select.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/select2/select2.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/bootstrap-tagsinput/bootstrap-tagsinput.css') }}">
@endsection

@section('scripts')
    <!-- Dependencies -->
    <script src="{{ asset('assets/vendor/libs/bootstrap-select/bootstrap-select.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/select2/select2.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/bootstrap-tagsinput/bootstrap-tagsinput.js') }}"></script>

    <script src="{{ asset('assets/js/forms_selects.js') }}"></script>
@endsection

@section('content')
    <h4 class="font-weight-bold py-3 mb-4">
        Рейтинг с телефоном
    </h4>

    <div class="card mb-4">
        <h6 class="card-header">
            Выберите категории
        </h6>
        <div class="card-body demo-vertical-spacing">
            <select class="selectpicker" data-style="btn-default" data-show-subtext="true">
                <option>Очное</option>
                <option>Заочное</option>
            </select>
            <br>
        </div>

        <div class="card-body demo-vertical-spacing">
            <select class="selectpicker" data-style="btn-default" data-show-subtext="true">
                <option>Бакалавр</option>
                <option>Магистр</option>
            </select>
            <br>
        </div>

        <div class="card-body demo-vertical-spacing">
            <select class="selectpicker" data-style="btn-default" data-show-subtext="true">
                <option>ИФМИТ</option>
                <option>ИКИ</option>
            </select>
            <br>
        </div>
    </div>

@endsection

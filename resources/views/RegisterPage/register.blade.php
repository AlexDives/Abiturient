@extends('layout.layout-blank')

@section('styles')
    <!-- Page -->
    <link rel="stylesheet" href="{{ asset('assets/vendor/css/pages/authentication.css') }}">
	<link href="{{ asset('fonts/fonts/font-awesome.min.css') }}" rel="stylesheet">
	<link href="{{ asset('css/toastr.min.css') }}" rel="stylesheet">
@endsection
@section('scripts')
    <script src="{{ asset('js/jquery.min.js') }}"></script>
    <script src="{{ asset('js/jquery.sweet-modal.min.js') }}"></script>
    <script src="{{ asset('js/sweetalert4.min.js') }}"></script>
    <script src="{{ asset('js/toastr.min.js') }}"></script>
    <script src="{{ asset('js/reg.js') }}"></script>
    <script src='https://www.google.com/recaptcha/api.js'></script>
@endsection

@section('content')
    <div class="authentication-wrapper authentication-1 px-4">
        <div class="authentication-inner py-5">

            <!-- Logo -->
            <div class="d-flex justify-content-center align-items-center">
                <div class="ui-w-60">
                    <div class="w-100 position-relative" style="padding-bottom: 54%">
                        <svg class="w-100 h-100 position-absolute" viewBox="0 0 148 80" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"><defs><linearGradient id="a" x1="46.49" x2="62.46" y1="53.39" y2="48.2" gradientUnits="userSpaceOnUse"><stop stop-opacity=".25" offset="0"></stop><stop stop-opacity=".1" offset=".3"></stop><stop stop-opacity="0" offset=".9"></stop></linearGradient><linearGradient id="e" x1="76.9" x2="92.64" y1="26.38" y2="31.49" xlink:href="#a"></linearGradient><linearGradient id="d" x1="107.12" x2="122.74" y1="53.41" y2="48.33" xlink:href="#a"></linearGradient></defs><path class="fill-primary" transform="translate(-.1)" d="M121.36,0,104.42,45.08,88.71,3.28A5.09,5.09,0,0,0,83.93,0H64.27A5.09,5.09,0,0,0,59.5,3.28L43.79,45.08,26.85,0H.1L29.43,76.74A5.09,5.09,0,0,0,34.19,80H53.39a5.09,5.09,0,0,0,4.77-3.26L74.1,35l16,41.74A5.09,5.09,0,0,0,94.82,80h18.95a5.09,5.09,0,0,0,4.76-3.24L148.1,0Z"></path><path transform="translate(-.1)" d="M52.19,22.73l-8.4,22.35L56.51,78.94a5,5,0,0,0,1.64-2.19l7.34-19.2Z" fill="url(#a)"></path><path transform="translate(-.1)" d="M95.73,22l-7-18.69a5,5,0,0,0-1.64-2.21L74.1,35l8.33,21.79Z" fill="url(#e)"></path><path transform="translate(-.1)" d="M112.73,23l-8.31,22.12,12.66,33.7a5,5,0,0,0,1.45-2l7.3-18.93Z" fill="url(#d)"></path></svg>
                    </div>
                </div>
            </div>
            <!-- / Logo -->
        <!-- Form -->
        <form class="my-5" action="{{ route('register') }}" method="post" id="regForm">
            {{ csrf_field() }}
            <div class="form-group">
                <label class="form-label">Введите логин</label>
                <input name="Name_login" id="Name_login" type="text" class="form-control" onblur="check_login()">
            </div>
            <div class="form-group">
                <label class="form-label">Введите фамилию</label>
                <input name="First_Name" type="text" class="form-control">
            </div>
            <div class="form-group">
                <label class="form-label">Введите имя</label>
                <input name="Name" type="text" class="form-control">
            </div>
            <div class="form-group">
                <label class="form-label">Введите отчество</label>
                <input name="Last_Name" type="text" class="form-control">
            </div>
            <div class="form-group">
                <label class="form-label">Введите E-mail</label>
                <input name="Email" id="Email" type="text" class="form-control" onblur="check_email()">
            </div>
            <div class="form-group">
                <label class="form-label">Введите пароль</label>
                <input name="Name_password" id="Name_password" type="password" class="form-control">
            </div>
            <div class="form-group">
                <label class="form-label">Введите пароль повторно</label>
                <input name="Name_password_two" id="Name_password_two" type="password" class="form-control" onblur="checkPass()">
            </div>
            <input type="hidden" name="captcha" id="captcha" value="">
			<div class="g-recaptcha" data-sitekey="6LfwCtUUAAAAAJ7rw_7LyfpDHrAF5dgaUJpuJTQd"></div>
            <button type="button" id="reg" class="btn btn-primary btn-block mt-4">Регистрация</button>
        </form>
        <!-- / Form -->

        <div class="text-center text-muted">
            Если вы имеете аккаунт? <a href="{{ url('/') }}">Авторизация</a>
        </div>

    </div>
</div>
<!-- / Content -->
@endsection

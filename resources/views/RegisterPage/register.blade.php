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
                <img src="{{ asset("images/logo.png") }}" alt="" style="width: 80px; height: auto;">
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

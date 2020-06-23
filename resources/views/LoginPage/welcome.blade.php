@extends('layout.layout-blank')

@section('styles')
    <!-- Page -->
    <link rel="stylesheet" href="{{ asset('assets/vendor/css/pages/authentication.css') }}">
@endsection

@section('content')
    <div class="authentication-wrapper authentication-1 px-4">
        <div class="authentication-inner py-5">
            <!-- Logo -->
            <div class="d-flex justify-content-center align-items-center">
                <img src="{{ asset("images/logo.png") }}" alt="" style="width: 150px; height: auto;">
            </div>
            <!-- / Logo -->
            <!-- Form -->
            <form class="my-5" action="{{ route('login') }}" method="post" >
                {{ csrf_field() }}
                <div class="form-group" >
                    <label class="form-label">Введите логин</label>
                    <input type="text" name="email" value="{{ old('username') }}" class="form-control">
               </div>
                <div class="form-group">
                    <label class="form-label d-flex justify-content-between align-items-end">
                        <div>Пароль</div>
                        <a href="{{ url('/reset-password') }}" class="d-block small">Забыли пароль</a>
                    </label>
                    <input type="password" name="password" class="form-control">
                </div>

                <div class="d-flex justify-content-between align-items-center m-0">
                    <label class="custom-control custom-checkbox m-0">
                        <input type="checkbox" class="custom-control-input">
                        <span class="custom-control-label">Запомнить</span>
                    </label>
                    <button type="submit" class="btn btn-primary">Ввойти</button>
                </div>
            </form>
            <!-- / Form -->
            <div class="text-center text-muted text-reg-func">
                Перейти на <a href="{{ url('/register') }}">Регистрацию</a>
            </div>
        </div>
    </div>
<script src="{{ asset('js/timescript.js') }}"></script>
@endsection

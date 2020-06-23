@extends('layout.error-layout')

@section('content')
<div class="error-page-wrapper">
  <div class="error-page-block">
   <div class="col"><img src="{{asset('images/logo.png')}}" alt=""></div>
   <div class="col">ИЗВИНИТЕ, ДАННАЯ ФУНКЦИЯ ДОСТУПНА ТОЛЬКО С <b>9:00</b> до <b>15:00</b>!</div>
   <div class="col"><a href="#" onclick="history.back();">Вернуться назад</a></div>
  </div>
</div>
@endsection

@extends('layout.layout-2-flex')

@section('styles')
    <!-- Page -->
    <link rel="stylesheet" href="{{ asset('assets/vendor/css/pages/clients.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables/datatables.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
@endsection

@section('scripts')
    <script src="{{ asset('assets/js/pages_clients.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/datatables/datatables.js') }}"></script>
@endsection

@section('content')
    <!-- `.clients-wrapper` fills all available space of container -->
    <div class="clients-wrapper">

        <!-- `.clients-content` fills all available space of `clients-wrapper` -->
        <div class="clients-content clients-scroll container-p-x container-p-y">

            <!-- Header -->
            <h4 class="d-flex flex-wrap justify-content-between align-items-center font-weight-bold pt-2 mb-4">
                <div class="mb-2">Список абитуриентов</div>
                <div class="mb-2" >
                    <p><a  href="{{ url('/insert_abit?pid=-1') }}" class="btn btn-primary rounded-pill d-block"><span class="ion ion-md-add"></span>&nbsp; Новый абитуриент</a></p>
                    @if($role == 1) <p><a href="{{ url('/direction') }}" class="btn btn-primary rounded-pill d-block"><span class="ion ion-md-add"></span>&nbsp; Новое направление</a></p>@endif
                </div>

            </h4>
            <!-- / Header -->

            <!-- Clients list -->
            <div class="table-responsive ui-bordered">
                <table id="table" class="clients-table table table-hover m-0">

                    <thead>
                    <tr>
                        <th>№</th>
                        <th>Проверен</th>
                        <th>Ф.И.О.</th>
                        <th>Льготы</th>
                        <th>Телефон №1</th>
                        <th>Телефон №2</th>
                        <th>Email</th>
                        <th>Действия</th>
                    </tr>
                    </thead>

                </table>
            </div>
            <!-- / Clients list -->

        </div><!-- / .clients-content -->

        <!-- Clients sidebox -->
        <div class="clients-sidebox bg-body border-left">
            <a href="javascript:void(0)" class="clients-sidebox-close text-muted text-xlarge font-weight-light">&times;</a>

            <div class="clients-scroll container-p-y">

                <!-- Client info -->
                <div class="text-center p-4">
                    <img src=" " class="ui-w-100 rounded-circle mb-4 persons-avatar-sidebar" alt="">
                    <h5 class="mb-1"><a href="javascript:void(0)" class="text-body text-body-famil"></a></h5>
                    <h5 class="mb-1"><a href="javascript:void(0)" class="text-body text-body-name"></a></h5>
                    <h5 class="mb-1"><a href="javascript:void(0)" class="text-body text-body-otch"></a></h5>
                    <div class="text-muted small mb-2 text-body-birthday">Дата рождения: 12.12.1995</div>
                </div>
                <!-- / Client info -->
                <hr class="border-light m-0">

                <div class="nav-tabs-top mb-4">
                    <div class="card-header">
                        <ul class="nav nav-pills card-header-pills nav-responsive-md">
                            <li class="nav-item">
                                <a class="nav-link active" data-toggle="tab" href="#tab_spesial" style="">Специальность</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="tab" href="#tab-predmet" style="">Предмет</a>
                            </li>
                        </ul>
                    </div>
                    <div class="tab-content">
                        <div class="tab-pane fade active show" id="tab_spesial">
                            <table class="table card-table shtb" id="shtb">
                                <thead>
                                <tr>
                                    <th>Шифр</th>
                                    <th>Специальность</th>
                                    <th>Возврат</th>
                                </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                        </div>
                        <div class="tab-pane fade" id="tab-predmet">
                            <table class="table card-table" id="dashboard-abit-exams-table">
                                <thead>
                                <tr>
                                    <th>Предмет</th>
                                    <th>Дата</th>
                                    <th>Балл</th>
                                </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- / Clients sidebox -->
    </div>
    <!-- / Clients wrapper -->
    <script>

    </script>
@endsection

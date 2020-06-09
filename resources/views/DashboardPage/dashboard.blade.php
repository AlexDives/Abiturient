@extends('layout.layout-2-flex')

@section('styles')
    <!-- Page -->
    <link rel="stylesheet" href="{{ asset('assets/vendor/css/pages/clients.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables/datatables.css') }}">
@endsection

@section('scripts')
    <script src="{{ asset('assets/js/pages_clients.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/datatables/datatables.js') }}"></script>
    <script>
        $(function() {
            $('#table').dataTable({
                processing: true,
                //  serverSide: true,
                ajax: '/loadTable',
                //Заменить с eng на ru
                language:
                    {
                        "processing": "Подождите...",
                        "search": "Поиск:",
                        "lengthMenu": "Показать _MENU_ записей",
                        "info": "Записи с _START_ до _END_ из _TOTAL_ записей",
                        "infoEmpty": "Записи с 0 до 0 из 0 записей",
                        "infoFiltered": "(отфильтровано из _MAX_ записей)",
                        "infoPostFix": "",
                        "loadingRecords": "Загрузка записей...",
                        "zeroRecords": "Записи отсутствуют.",
                        "emptyTable": "В таблице отсутствуют данные",
                        "paginate":
                            {
                                "first": "Первая",
                                "previous": "Предыдущая",
                                "next": "Следующая",
                                "last": "Последняя"
                            },
                        "aria":
                            {
                                "sortAscending": ": активировать для сортировки столбца по возрастанию",
                                "sortDescending": ": активировать для сортировки столбца по убыванию"
                            },
                        "select":
                            {
                                "rows":
                                    {
                                        "_": "Выбрано записей: %d",
                                        "0": "Кликните по записи для выбора",
                                        "1": "Выбрана одна запись"
                                    }
                            }
                    },
                //Отрисовать кнопки
                createdRow: function (row, data, index)
                {
                    $('td', row).eq(6).html('').append
                    (
                        '<a href="/profile" class="btn btn-default btn-xs icon-btn md-btn-flat product-tooltip" title="Открыть"><i class="ion ion-md-create"></i></a>&nbsp;' +
                        '<a href="javascript:void(0)" class="btn btn-default btn-xs icon-btn md-btn-flat product-tooltip" title="Удалить"><i class="ion ion-md-close"></i></a>'
                    );
                }
            });
        });
    </script>
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
                    <p><a  href="{{ url('/insert_abit') }}" class="btn btn-primary rounded-pill d-block"><span class="ion ion-md-add"></span>&nbsp; Новый абитуриент</a></p>
                    <p><a href="{{ url('/direction') }}" class="btn btn-primary rounded-pill d-block"><span class="ion ion-md-add"></span>&nbsp; Новое направление</a></p>
                </div>

            </h4>
            <!-- / Header -->

            <!-- Clients list -->
            <div class="table-responsive ui-bordered">
                <table id="table" class="clients-table table table-hover m-0">

                    <thead>
                    <tr>
                        <th>№</th>
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
                            <table class="table card-table" id="shtb">
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
                            <table class="table card-table">
                                <thead>
                                <tr>
                                    <th>Предмет</th>
                                    <th>Дата</th>
                                    <th>Балл</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td class="align-middle">Русский язык</td>
                                    <td class="align-middle">12.12.2019</td>
                                    <td class="align-middle">78.3</td>
                                </tr>

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
@endsection

<?php $routeName = Route::currentRouteName(); ?>

<!-- Layout sidenav -->
<div id="layout-sidenav" class="{{ isset($layout_sidenav_horizontal) ? 'layout-sidenav-horizontal sidenav-horizontal container-p-x flex-grow-0' : 'layout-sidenav sidenav-vertical' }} sidenav bg-sidenav-theme">
    @empty($layout_sidenav_horizontal)
    <!-- Brand demo (see assets/css/demo/demo.css) -->
    <div class="app-brand demo">
        <span class="app-brand-logo demo bg-primary">
            <img src="{{ asset("images/logo.png") }}" alt="" style="width: 30px; height: auto;">
        </span>
        <a href="/" class="app-brand-text demo sidenav-text font-weight-normal ml-2">Абитуриент</a>
        <a href="javascript:void(0)" class="layout-sidenav-toggle sidenav-link text-large ml-auto">
            <i class="ion ion-md-menu align-middle"></i>
        </a>
    </div>

    <div class="sidenav-divider mt-0"></div>
    @endempty
    <!-- Links -->
    <ul class="sidenav-inner{{ empty($layout_sidenav_horizontal) ? ' py-1' : '' }}">

        <!-- Основная страница -->
        <li class="sidenav-item{{ strpos($routeName, 'dashboards.') === 0 ? ' active open' : '' }}">
            <a href="javascript:void(0)" class="sidenav-link sidenav-toggle"><i class="sidenav-icon ion ion-md-grid"></i><div>Основное</div></a>

            <ul class="sidenav-menu">
                <li class="sidenav-item{{ $routeName == 'dashboards.dashboard-1' ? ' active' : '' }}">
                    <a href="/dashboard" class="sidenav-link"><div>Список абитуриентов</div></a>
                </li>
            </ul>
        </li>
             <!--  Графики данных
        <li class="sidenav-item{{ strpos($routeName, 'charts.') === 0 ? ' active open' : '' }}">
            <a href="javascript:void(0)" class="sidenav-link sidenav-toggle"><i class="sidenav-icon ion ion-md-pie"></i><div>Тестовый вариант</div></a>

            <ul class="sidenav-menu">
                <li class="sidenav-item{{ $routeName == 'charts.chartjs' ? ' active' : '' }}">
                    <a href="{{ route('charts.chartjs') }}" class="sidenav-link"><div>Второй вариант </div></a>
                </li>
            </ul>
        </li> -->
         <!--   Ведомости
        <li class="sidenav-item{{ strpos($routeName, 'charts.') === 0 ? ' active open' : '' }}">
            <a href="javascript:void(0)" class="sidenav-link sidenav-toggle"><i class="sidenav-icon ion ion-md-switch"></i><div>Ведомости</div></a>

            <ul class="sidenav-menu">
                <li class="sidenav-item{{ $routeName == 'charts.chartjs' ? ' active' : '' }}">
                    <a href="{{ route('charts.chartjs') }}" class="sidenav-link"><div>Формирование печати (экзамены)</div></a>
                </li>
                <li class="sidenav-item{{ $routeName == 'charts.chartjs' ? ' active' : '' }}">
                    <a href="{{ route('charts.chartjs') }}" class="sidenav-link"><div>Формирование печати (собесодание)</div></a>
                </li>
            </ul>
        </li> -->
       <!--   Журналы
        <li class="sidenav-item{{ strpos($routeName, 'charts.') === 0 ? ' active open' : '' }}">
            <a href="javascript:void(0)" class="sidenav-link sidenav-toggle"><i class="sidenav-icon ion ion-logo-buffer"></i><div>Журналы</div></a>

            <ul class="sidenav-menu">
                <li class="sidenav-item{{ $routeName == 'charts.chartjs' ? ' active' : '' }}">
                    <a href="{{ route('charts.chartjs') }}" class="sidenav-link"><div>Печать журнала</div></a>
                </li>
            </ul>
        </li>  -->
       <!--   Рейтинги
        <li class="sidenav-item{{ strpos($routeName, 'reting.') === 0 ? ' active open' : '' }}">
            <a href="javascript:void(0)" class="sidenav-link sidenav-toggle"><i class="sidenav-icon ion ion-ios-podium"></i><div>Рейтинги</div></a>

            <ul class="sidenav-menu">
                <li class="sidenav-item{{ $routeName == 'reting.reting_phone' ? ' active' : '' }}">
                    <a href="{{ route('reting.reting_phone') }}" class="sidenav-link"><div>Предварительный рейтинг</div></a>
                </li>
                <li class="sidenav-item{{ $routeName == 'reting.reting_phone' ? ' active' : '' }}">
                    <a href="{{ route('reting.reting_phone') }}" class="sidenav-link"><div>Расчет рейтинга</div></a>
                </li>
                <li class="sidenav-item{{ $routeName == 'reting.reting_phone' ? ' active' : '' }}">
                    <a href="{{ route('reting.reting_phone') }}" class="sidenav-link"><div>Рейтинг с телефонами</div></a>
                </li>
            </ul>
        </li>  -->
     <!--   Приказы
        <li class="sidenav-item{{ strpos($routeName, 'charts.') === 0 ? ' active open' : '' }}">
            <a href="javascript:void(0)" class="sidenav-link sidenav-toggle"><i class="sidenav-icon ion ion-md-pie"></i><div>Приказы</div></a>

            <ul class="sidenav-menu">
                <li class="sidenav-item{{ $routeName == 'charts.chartjs' ? ' active' : '' }}">
                    <a href="{{ route('charts.chartjs') }}" class="sidenav-link"><div>Данные о приказе</div></a>
                </li>
                <li class="sidenav-item{{ $routeName == 'charts.chartjs' ? ' active' : '' }}">
                    <a href="{{ route('charts.chartjs') }}" class="sidenav-link"><div>Перенос людей в приказ</div></a>
                </li>
                <li class="sidenav-item{{ $routeName == 'charts.chartjs' ? ' active' : '' }}">
                    <a href="{{ route('charts.chartjs') }}" class="sidenav-link"><div>Печать приказов</div></a>
                </li>
                <li class="sidenav-item{{ $routeName == 'charts.chartjs' ? ' active' : '' }}">
                    <a href="{{ route('charts.chartjs') }}" class="sidenav-link"><div>Перенос гос. заказа в приказы</div></a>
                </li>
            </ul>
        </li>  -->
       <!--   Отчеты
        <li class="sidenav-item{{ strpos($routeName, 'reports.') === 0 ? ' active open' : '' }}">
            <a href="javascript:void(0)" class="sidenav-link sidenav-toggle"><i class="sidenav-icon ion ion-md-document"></i><div>Отчеты</div></a>

            <ul class="sidenav-menu">
                <li class="sidenav-item{{ $routeName == 'reports.rep_spesial' ? ' active' : '' }}">
                    <a href="{{ route('reports.rep_spesial') }}" class="sidenav-link"><div>Заявлений по специальности</div></a>
                </li>
                <li class="sidenav-item{{ $routeName == 'charts.chartjs' ? ' active' : '' }}">
                    <a href="{{ route('charts.chartjs') }}" class="sidenav-link"><div>Заявлений по факультету</div></a>
                </li>
                <li class="sidenav-item{{ $routeName == 'charts.chartjs' ? ' active' : '' }}">
                    <a href="{{ route('charts.chartjs') }}" class="sidenav-link"><div>Количество предметных мест</div></a>
                </li>
                <li class="sidenav-item{{ $routeName == 'charts.chartjs' ? ' active' : '' }}">
                    <a href="{{ route('charts.chartjs') }}" class="sidenav-link"><div>Предметы + все люди</div></a>
                </li>
                <li class="sidenav-item{{ $routeName == 'charts.chartjs' ? ' active' : '' }}">
                    <a href="{{ route('charts.chartjs') }}" class="sidenav-link"><div>Предметы + все люди(МС)</div></a>
                </li>
            </ul>
        </li>
         -->


    </ul>
</div>
<!-- / Layout sidenav -->

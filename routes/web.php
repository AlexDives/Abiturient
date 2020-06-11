<?php

/*
|--------------------------------------------------------------------------
| ВЕБ-РОУТИНГ
|--------------------------------------------------------------------------
|
|	Здесь вы можете зарегистрировать веб-маршруты для вашего приложения. Эти
| 	маршруты загружаются RouteServiceProvider в группе, которая
| 	содержит группу промежуточного программного обеспечения "web" Теперь создайте что-то великое!
|
*/

Route::get('/', 'LoginController@check');
//=============== Отображение страницы Авторизация ================================//
Route::post('login', 'LoginController@login')->name('login');
//=============== Отображение страницы Регистрация ================================//
Route::post('register', 'RegisterController@create')->name('register');
//=============== Процесс регистрации нового пользователя =========================//
Route::get('/register', 'RegisterController@index');
//=============== Проверка на существующий логин =========================//
Route::post('/Check_login', 'RegisterController@check_login');
//=============== Проверка на существующий email =========================//
Route::post('/Check_email', 'RegisterController@check_email');
//=============== Процесс верификации (переходит из письма) =========================//
Route::get('/verificate', 'RegisterController@verificate');
//=============== Отображение страницы dashboard ==================================//
Route::get('/dashboard', 'DashboardController@index')->name('dashboards.dashboard-1')->middleware('check');
//=============== Вызгрузка данных json в таблицу dashboard ================================//
Route::get('/loadTable', 'DashboardController@loadTable');
//=============== Вызгрузка данных json в sidebar dashboard ================================//
Route::get('/loadSidebar', 'DashboardController@loadSidebar');
//=============== Вызгрузка данных json в sidebar таблицу поданных заявлений dashboard ================================//
Route::get('/PersonsStatmentTable', 'DashboardController@PersonsStatmentTable');
//=============== Вызгрузка данных json в sidebar таблицу экзаменов dashboard ================================//
Route::get('/PersonsExamsTable', 'DashboardController@PersonsExamsTable');
//=============== Отображение шаблона Направления ================================//
Route::get('/direction', 'DirectionController@index');
//=============== Отображение факультетот в шаблоне Направления ================================//
Route::post('/direction/get_facultet', 'DirectionController@get_facultet');
//=============== Сохрание данных направления и теста ================================//
Route::post('/direction/save', 'DirectionController@save');
//=============== Отображение шаблона Направления ================================//
Route::get('/scanPhoto', 'ScanController@index');
//=============== Заполнение информации о направлении абитуриента(нового) ================================//
Route::get('/insert_abit', 'ProfileController@index_InsertAbit')->middleware('check');
//=============== Заполнение информации о направлении абитуриента(уже создан) ================================//
Route::get('/success_insert_abit', 'ProfileController@index_Success_Abit')->middleware('check');

//=============== Разрыв сессии ================================//
Route::get('logout', 'DashboardController@logout')->name('logout');
//=============== Отображение страницы Личной карты абитуриента ================================//
Route::get('/profile', 'ProfileController@index_Profile')->name('profile')->middleware('check');
//=============== Отображение страницы Личной карты абитуриента ================================//
Route::post('/profilesave', 'ProfileController@save_Profile')->middleware('check');
//=============== Удаление сертификата абитуриента ================================//
Route::post('/sert/del', 'ProfileController@delete_sertificate')->middleware('check');

Route::post('/upload/dock', 'ProjectsController@uploadDOCUMENTS')->name('updlode.dock');
//=============== Загрузка фотографии абитуриента ================================//
Route::post('/upload/photo', 'ProfileController@upload_Photo')->middleware('check');

//=============== КАК-ТО ПОТОМ =================================================//
//=============== Отображение страницы Графиков ================================//
Route::get('charts/chartjs', 'ChartsController@index')->name('charts.chartjs')->middleware('check');
//=============== Отображение страницы Рейтингов ================================//
Route::get('reting/reting_phone', 'Reting\RetingController@index')->name('reting.reting_phone')->middleware('check');
//=============== Отображение страницы Отчетов Специальности ================================//
Route::get('reports/rep_spesial','Reports\Report_SpesialController@index')->name('reports.rep_spesial')->middleware('check');
//=============== Отображение страницы Восстановление пароля ======================//
Route::get('/reset-password', 'ResetPasswordController@index');
//=============== Отображение страницы Контактов  ================================//
Route::get('/contact', 'Contact\ContactController@index')->middleware('check');
//=============== Отображение страницы Тех.поддержки  ============================//
Route::get('/support', 'Support\SupportController@index')->middleware('check');

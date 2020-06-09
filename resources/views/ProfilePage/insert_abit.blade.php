@extends('layout.layout-2')

@section('styles')
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/select2/select2.css') }}">
    <!-- Page -->
    <link rel="stylesheet" href="{{asset('assets/vendor/libs/smartwizard/smartwizard.css')}}">
@endsection

@section('scripts')
    <script src="{{ asset('assets/vendor/libs/smartwizard/smartwizard.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/validate/validate.js') }}"></script>

    <script src="{{ asset('assets/vendor/libs/select2/select2.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/vanilla-text-mask/vanilla-text-mask.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/vanilla-text-mask/text-mask-addons.js') }}"></script>
    <script>
        //Маска ввода - даты
        vanillaTextMask.maskInput({
            inputElement: $('#date_birth')[0],
            mask: [/\d/, /\d/, '.', /\d/, /\d/, '.', /\d/, /\d/, /\d/, /\d/],
            pipe: textMaskAddons.createAutoCorrectedDatePipe('dd.mm.yyyy')
        });
        vanillaTextMask.maskInput({
            inputElement: $('#date_vidach')[0],
            mask: [/\d/, /\d/, '.', /\d/, /\d/, '.', /\d/, /\d/, /\d/, /\d/],
            pipe: textMaskAddons.createAutoCorrectedDatePipe('dd.mm.yyyy')
        });

        //Телефон
        vanillaTextMask.maskInput({
            inputElement: $('#mask-phone')[0],
            mask: ['(', /[1-10]/, /\d/, /\d/, ')', ' ', /\d/, /\d/, /\d/, '-', /\d/, /\d/, /\d/, /\d/]
        });

        // Числа
        //
        vanillaTextMask.maskInput({
            inputElement: $('#mask-number')[0],
            mask: textMaskAddons.createNumberMask({prefix:'#'})
        });



        // Initialize Select2 multiselect box
        $('select[name="validation-select2-multi"]').select2({
            placeholder: 'Select gear...',
        }).change(function() {
            $(this).valid();
        });

        $(function() {
            $('.smartwizard-example').smartWizard({
                autoAdjustHeight: false,
                backButtonSupport: false,
                useURLhash: false,
                showStepURLhash: false

            });

            $('#smartwizard-4 .sw-toolbar').appendTo($('#smartwizard-4 .sw-container'));
            $('#smartwizard-5 .sw-toolbar').appendTo($('#smartwizard-5 .sw-container'));
        });

        // Валидация
        $(function() {
            var $form = $('#smartwizard-6');
            var $btnFinish = $('<button class="btn-finish btn btn-primary hidden mr-2" type="button">Завершить</button>');

            // Вывод ошибки
            $form.validate({
                errorPlacement: function errorPlacement(error, element) {
                    $(element).parents('.form-group').append(
                        error.addClass('invalid-feedback small d-block ')
                    )
                },
                highlight: function(element) {
                    $(element).addClass('is-invalid');
                },
                unhighlight: function(element) {
                    $(element).removeClass('is-invalid');
                },
                rules: {
                    'wizard-confirm': {
                        equalTo: 'input[name="wizard-password"]'
                    }
                }
            });

            // Создание - wizard
            $form
                .smartWizard({
                    autoAdjustHeight: false,
                    backButtonSupport: false,
                    useURLhash: false,
                    showStepURLhash: false,
                    lang: {  // Language variables
                        next: 'Вперед',
                        previous: 'Назад'
                    },
                    toolbarSettings: {
                        toolbarExtraButtons: [$btnFinish]
                    }
                })
                .on('leaveStep', function(e, anchorObject, stepNumber, stepDirection) {
                    // stepDirection === 'forward': - это условие позволяет выполнить проверку формы
                    // только при навигации вперед, что облегчает навигацию назад, все еще выполняет проверку при переходе далее
                    if (stepDirection === 'forward'){ return $form.valid(); }
                    return true;
                })
                .on('showStep', function(e, anchorObject, stepNumber, stepDirection) {
                    var $btn = $form.find('.btn-finish');

                    // Включить кнопку завершения только на последнем шаге
                    if (stepNumber === 3) {
                        $btn.removeClass('hidden');
                    } else {
                        $btn.addClass('hidden');
                    }
                });

            // Click on "Завершить"
            $form.find('.btn-finish').on('click', function(){
                //Нужно как-то поставить условие что валидация пройдена на последней форме
                if (!$form.valid()){ return; }
                // При завершении
                alert("Успех.");
                return false;
            });
        });

    </script>

@endsection


@section('content')
    <div class="container-fluid flex-grow-1 container-p-y">

        <h4 class="font-weight-bold py-3 mb-4">
            <span class="text-muted font-weight-light"></span> Регистрация абитуриента
        </h4>
        <hr class="container-m-nx border-light my-4">

        <form id="smartwizard-6" action="javascript:void(0)">

            <ul class="card px-4 pt-3 mb-4">
                <li>
                    <a href="#smartwizard-6-step-1" class="mb-3">
                        <span class="sw-done-icon ion ion-md-checkmark"></span>
                        <span class="sw-number">1</span>
                        Выбор направления
                    </a>
                </li>
                <li>
                    <a href="#smartwizard-6-step-2" class="mb-3">
                        <span class="sw-done-icon ion ion-md-checkmark"></span>
                        <span class="sw-number">2</span>
                        Основная информация
                    </a>
                </li>
                <li>
                    <a href="#smartwizard-6-step-3" class="mb-3">
                        <span class="sw-done-icon ion ion-md-checkmark"></span>
                        <span class="sw-number">3</span>
                        Паспортные данные
                    </a>
                </li>
                <li>
                    <a href="#smartwizard-6-step-4" class="mb-3">
                        <span class="sw-done-icon ion ion-md-checkmark"></span>
                        <span class="sw-number">4</span>
                        Документы об образовании
                    </a>
                </li>

                <li>
                    <a href="#smartwizard-6-step-5" class="mb-3">
                        <span class="sw-done-icon ion ion-md-checkmark"></span>
                        <span class="sw-number">5</span>
                        Результаты ЕГЭ/ВНО
                    </a>
                </li>

            </ul>
            <!-- Выбор направления -->
            <div class="mb-3">
                <div id="smartwizard-6-step-1" class="card animated fadeIn">
                    <div class="card-body">
                        <div class="form-group">
                            <label class="form-label">Форма обучения
                                <span class="text-danger">*</span>
                            </label>
                            <select class="form-control required" name="validation-select2" style="width: 100%" data-allow-clear="true">
                                <option></option>
                                <option value="1">Очное</option>
                                <option value="2">Заочное</option>
                            </select>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Институт/Факультет
                                <span class="text-danger">*</span>
                            </label>
                            <select class="form-control required" name="validation-select2" style="width: 100%" data-allow-clear="true">
                                <option></option>
                                <option value="1">ИФМИТ</option>
                                <option value="2">ИПП</option>
                            </select>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Специальность
                                <span class="text-danger">*</span>
                            </label>
                            <select class="form-control required" name="validation-select2" style="width: 100%" data-allow-clear="true">
                                <option></option>
                                <option value="1101">Программная инженерия</option>
                                <option value="1110">Информатика</option>
                            </select>
                            </select>
                        </div>

                    </div>
                </div>

                <!-- Основная информация -->
                <div id="smartwizard-6-step-2" class="card animated fadeIn">
                    <div class="card-body">
                        <form>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label class="form-label">Email</label>
                                    <input type="email" class="form-control" placeholder="Email">
                                </div>
                                <div class="form-group col-md-6">
                                    <label class="form-label">Password</label>
                                    <input type="password" class="form-control" placeholder="Password">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Address</label>
                                <input type="text" class="form-control" placeholder="1234 Main St">
                            </div>
                            <div class="form-group">
                                <label class="form-label">Address 2</label>
                                <input type="text" class="form-control" placeholder="Apartment, studio, or floor">
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label class="form-label">City</label>
                                    <input type="text" class="form-control">
                                </div>
                                <div class="form-group col-md-4">
                                    <label class="form-label">State</label>
                                    <select class="custom-select">
                                        <option>Select state</option>
                                        <option>California</option>
                                        <option>Hawaii</option>
                                        <option>Florida</option>
                                        <option>Texas</option>
                                        <option>Massachusetts</option>
                                        <option>Alabama</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-2">
                                    <label class="form-label">Zip</label>
                                    <input type="text" class="form-control">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="custom-control custom-checkbox m-0">
                                    <input type="checkbox" class="custom-control-input">
                                    <span class="custom-control-label">Check this custom checkbox</span>
                                </label>
                            </div>
                            <button type="submit" class="btn btn-primary">Sign in</button>
                        </form>
                    </div>
                </div>
                <!-- Паспортные данные -->
                <div id="smartwizard-6-step-3" class="card animated fadeIn">

                    <div class="card-body">
                        <div class="row">
                            <div class="col">
                                <div class="form-group">
                                    <label class="form-label">Тип документа
                                        <span class="text-danger">*</span>
                                    </label>
                                    <select class="form-control required" name="validation-select2" style="width: 100%" data-allow-clear="true">
                                        <option value="LNR">ТН</option>
                                        <option value="UA">ЕН</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <label class="form-label">Дата выдачи
                                        <span class="text-danger">*</span>
                                    </label>
                                    <input name="wizard-Date" id="date_vidach"  type="text" class="form-control required" placeholder="__.__.____">
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <label class="form-label">Идентификационный код
                                        <span class="text-danger">*</span>
                                    </label>
                                    <input name="wizard-Code" id="mask-number" type="text" class="form-control required">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <div class="form-group">
                                    <label class="form-label">Серия документа
                                        <span class="text-danger">*</span>
                                    </label>
                                    <input name="wizard-Seria" type="text" class="form-control required">
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <label class="form-label">Номер документа
                                        <span class="text-danger">*</span>
                                    </label>
                                    <input name="wizard-numberDoc" type="text" class="form-control required">
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Кем выдан документ
                                <span class="text-danger">*</span>
                            </label>
                            <input name="wizard-vid" type="text" class="form-control required">
                        </div>

                        <div class="form-group">
                            <label class="form-label">Тип льгот
                                <span class="text-danger">*</span>
                            </label>
                            <select class="form-control"  style="width: 100%" data-allow-clear="true">
                                <option></option>
                                <option value="LNR">Дети-сироты</option>
                            </select>
                        </div>

                    </div>

                </div>

                <!-- Образовательный уровень -->
                <div id="smartwizard-6-step-4" class="card animated fadeIn">
                    <div class="card-body">
                        <div class="form-group">
                            <label class="form-label">Образовательный уровень
                                <span class="text-danger">*</span>
                            </label>
                            <select class="form-control required" name="validation-select" style="width: 100%" data-allow-clear="true">
                                <option value="12">Среднее</option>
                                <option value="13">Бакалавр</option>
                                <option value="14">Магистр</option>
                                <option value="15">Бакалавр</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Учебное заведение
                                <span class="text-danger">*</span>
                            </label>
                            <input name="wizard-name_Univer" type="text" class="form-control required">
                        </div>

                        <div class="form-group">
                            <label class="form-label">Док-то об образовании</label>
                            <select class="form-control" name="validation-select" style="width: 100%" data-allow-clear="true">
                                <option value="12">Аттестат</option>
                                <option value="13">Диплом</option>
                            </select>
                        </div>

                        <div class="row">
                            <div class="col">
                                <label class="form-label">Год окончания</label>
                                <input type="text" name="wizard-Year" class="form-control required">
                            </div>
                            <div class="col">
                                <label class="form-label">Дата выдачи</label>
                                <input type="text" name="wizard-dateVid" class="form-control required" >
                            </div>
                        </div>

                        <div class="row">
                            <div class="col">
                                <div class="form-group">
                                    <label class="form-label">Серия документа</label>
                                    <input type="text" name="wizard-Serial" class="form-control required">
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <label class="form-label">Номер документа</label>
                                    <input type="text" name="wizard-number_dok" class="form-control required" >
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <div class="form-group">
                                    <label class="form-label">Номер приложения</label>
                                    <input type="text" name="wizard-numper_app" class="form-control required">
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <label class="form-label">Средний балл</label>
                                    <input type="text" name="wizard-avg_ball" class="form-control required">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Кем выдан документ
                                <span class="text-danger">*</span>
                            </label>
                            <input name="wizard-name_vid" type="text" class="form-control required">
                        </div>
                    </div>
                </div>
                    <!-- Результаты ЕГЭ -->
                <div id="smartwizard-6-step-5" class="card animated fadeIn">
                    <div class="card-body">
                        <div class="row">
                            <div class="col">
                                <div class="form-group">
                                    <label class="form-label">Тип сертификата</label>
                                    <select class="form-control required" name="validation-select" style="width: 100%" data-allow-clear="true">
                                        <option value="1">ЕГЭ</option>
                                        <option value="2">ВНО</option>
                                        <option value="3">ГИА</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <label class="form-label">Предмет</label>
                                    <select class="form-control required" name="wizard-select" style="width: 100%" data-allow-clear="true">
                                        <option value="1">Биология</option>
                                        <option value="2">География</option>
                                        <option value="3">Информатика</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <label class="form-label">Балл</label>
                                    <input type="text"  name="wizard-ball" class="form-control required">
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <label class="form-label">Серия</label>
                                    <input type="text"  name="wizard-name" class="form-control required">
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <label class="form-label">Номер</label>
                                    <input type="text" name="wizard-number" class="form-control required">
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <label class="form-label">Дата выдачи</label>
                                    <input type="text" name="wizard-date_vidach" class="form-control required">
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Кем выдан</label>
                            <input type="text"  name="wizard-kem" class="form-control required">
                        </div>
                    </div>
                </div>

            </div>
        </form>

    </div>
@endsection
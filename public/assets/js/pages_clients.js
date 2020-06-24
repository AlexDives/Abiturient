$(function() {

    //=============== Открытие боковой панели ================================//
    function openSidenav() {
        $('.clients-wrapper').addClass('clients-sidebox-open');
    }

    //=============== Закрытие боковой панели ================================//
    function closeSidenav() {
        $('.clients-wrapper').removeClass('clients-sidebox-open');
        $('.clients-table tr.bg-light').removeClass('bg-light');
    }

    //=============== Выбранный Абитуриент ================================//
    function selectClient(row) {
        openSidenav();
        $('.clients-table tr.bg-light').removeClass('bg-light');
        $(row).addClass('bg-light' + $(row).firstChild);
    }

    //=============== Событие при клике на строку таблицы AbitTable ================================//
    $('body').on('click', '.clients-table tr', function() {
        var id_person = this.cells[0].textContent;
        $.ajax({
            dataType: 'json',
            url: '/loadSidebar',
            type: 'GET',
            data: {
                idPersons: id_person
            },
            success: function(data) {
                $('.persons-avatar-sidebar').attr('src', data.Avatar)
                $('.text-body-famil').text('Фамилия: ' + data.FirstName);
                $('.text-body-name').text('Имя: ' + data.Name);
                $('.text-body-otch').text('Отчество: ' + data.LastName);
                $('.text-body-birthday').text('Дата Рождения:' + data.Birthday);
                PersonsStatmentTable(id_person);
                PersonsExamsTable(id_person)
                selectClient(this);
                //setTimeout(keek, 200);
              // var table = $('#shtb').DataTable();
              //  table.on( 'draw', function () {
             //  } );
            },
        });
    });


    //=============== Таблица поданных абитуриентом заявлений ================================//
    function PersonsStatmentTable(id_person) {
        $('#shtb').DataTable().destroy();
        $('#shtb').dataTable({

            processing: true,
            ordering: false,
            paging: false,
            searching: false,
            info: false,
            ajax: {
                url: '/PersonsStatmentTable',
                data: {
                    idPersons: id_person
                },
            },
           createdRow: function( row, data, dataIndex ) {

            if($(row).children(':nth-child(3)').text() != ''){
             $(row).addClass('return-row');
            }
           },
        });
    }

    //=============== Таблица Экзамнов Абитуриента ================================//
    function PersonsExamsTable(id_person) {
        $('#dashboard-abit-exams-table').DataTable().destroy();
        $('#dashboard-abit-exams-table').dataTable({
            processing: true,
            ordering: false,
            paging: false,
            searching: false,
            info: false,
            ajax: {
                url: '/PersonsExamsTable',
                data: {
                    idPersons: id_person
                },
            },
        });
    }

    //=============== Кнопка для закрытия боковой панели ================================//
    $('body').on('click', '.clients-sidebox-close', function(e) {
        e.preventDefault();
        closeSidenav();
    });

    //=============== Setup scrollbars ================================//
    $('.clients-scroll').each(function() {
        new PerfectScrollbar(this, {
            suppressScrollX: true,
            wheelPropagation: true
        });
    });

    //=============== Таблица для отображения абитуриентов AbitTable ================================//
    $('#table').dataTable({
        processing: true,
        //  serverSide: true,
        ajax: '/loadTable',
        //Заменить с eng на ru
        language: {
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
            "paginate": {
                "first": "Первая",
                "previous": "Предыдущая",
                "next": "Следующая",
                "last": "Последняя"
            },
            "aria": {
                "sortAscending": ": активировать для сортировки столбца по возрастанию",
                "sortDescending": ": активировать для сортировки столбца по убыванию"
            },
            "select": {
                "rows": {
                    "_": "Выбрано записей: %d",
                    "0": "Кликните по записи для выбора",
                    "1": "Выбрана одна запись"
                }
            }
        },
        "order": [[1, "asc" ]],
        //Отрисовать кнопки
        createdRow: function(row, data, index) {

           if($(row).children(':nth-child(2)').text() != ''){
            $(row).children(':nth-child(2)').addClass('checkd-row');
           }

            $('td', row).eq(7).html('').append(
                '<a href="/profile?pid=' + data[0] + '" class="btn btn-default btn-xs icon-btn md-btn-flat product-tooltip" title="Открыть"><i class="ion ion-md-create"></i></a>&nbsp;'
            );
        }
    });

});

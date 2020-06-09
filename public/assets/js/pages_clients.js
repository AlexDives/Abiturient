$(function() {

  function openSidenav() {
    $('.clients-wrapper').addClass('clients-sidebox-open');
  }

  function closeSidenav() {
    $('.clients-wrapper').removeClass('clients-sidebox-open');
    $('.clients-table tr.bg-light').removeClass('bg-light');
  }

  function selectClient(row) {
    openSidenav();
    $('.clients-table tr.bg-light').removeClass('bg-light');
    $(row).addClass('bg-light' + $(row).firstChild);
  }

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
          $('#shtb').DataTable().destroy();
          testTable(id_person);

          // Select client
          selectClient(this);
        },
      });
  });

  function testTable(id_person){
    $('#shtb').dataTable({

        processing: true,
        ordering:false,
        paging:false,
        searching: false,
        info: false,
        //  serverSide: true,
        ajax: {
             url: '/ShifrT',
             data: {
                 idPersons: id_person
             },
           },

      });
  }

  $('body').on('click', '.clients-sidebox-close', function(e) {
    e.preventDefault();
    closeSidenav();
  });

  // Setup scrollbars

  $('.clients-scroll').each(function() {
    new PerfectScrollbar(this, {
      suppressScrollX: true,
      wheelPropagation: true
    });
  });

});

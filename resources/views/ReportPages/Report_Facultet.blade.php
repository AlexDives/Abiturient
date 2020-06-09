@extends('layout.layout-2')

@section('styles')
 <link rel="stylesheet" href="{{ asset('assets/vendor/libs/bootstrap-datepicker/bootstrap-datepicker.css') }}">
 <link rel="stylesheet" href="{{ asset('assets/vendor/libs/bootstrap-daterangepicker/bootstrap-daterangepicker.css') }}">
@endsection

@section('scripts')
<!-- Dependencies -->
<script src="{{ asset('assets/vendor/libs/moment/moment.js') }}"></script>
<script src="{{ asset('assets/vendor/libs/bootstrap-datepicker/bootstrap-datepicker.js') }}"></script>
<script src="{{ asset('assets/vendor/libs/bootstrap-daterangepicker/bootstrap-daterangepicker.js') }}"></script>

<!--<script src="{{ asset('assets/js/forms_pickers.js') }}"></script> -->
<script>
$(function() {
  var isRtl = $('html').attr('dir') === 'rtl';

  $('#datepicker-base').datepicker({
    orientation: isRtl ? 'auto right' : 'auto left',
    format: 'dd/mm/yyyy'
  });
  $('#datepicker-features').datepicker({
    calendarWeeks:         true,
    todayBtn:              'linked',
    daysOfWeekDisabled:    '1',
    clearBtn:              true,
    todayHighlight:        true,
    multidate:             true,
    daysOfWeekHighlighted: '1,2',
    orientation: isRtl ? 'auto left' : 'auto right',

    beforeShowMonth: function(date) {
      if (date.getMonth() === 8) {
        return false;
      }
    },

    beforeShowYear: function(date){
      if (date.getFullYear() === 2014) {
        return false;
      }
    }
  });
  $('#datepicker-range').datepicker({
    orientation: isRtl ? 'auto right' : 'auto left'
  });
  $('#datepicker-inline').datepicker();
});
</script>
@endsection

@section('content')
    <h4 class="d-flex justify-content-between align-items-center w-100 font-weight-bold py-3 mb-4">
        <div>Количество заявлений по факультету</div>
    </h4>

    <!-- Filters -->
    <div class="ui-bordered px-4 pt-4 mb-4">
        <div class="input-daterange input-group" id="datepicker-range">
                  <input type="text" class="form-control" name="start">
                  <div class="input-group-prepend">
                    <span class="input-group-text">До</span>
                  </div>
                  <input type="text" class="form-control" name="end">
                </div>

            <div class="col-md col-xl-2 mb-4">
                <label class="form-label d-none d-md-block">&nbsp;</label>
                <button type="button" class="btn btn-secondary btn-block">Отобразить</button>
            </div>
        </div>
    </div>

@endsection

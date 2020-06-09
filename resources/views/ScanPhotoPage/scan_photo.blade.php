@extends('layout.layout-2')

@section('styles')
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/bootstrap-select/bootstrap-select.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/bootstrap-tagsinput/bootstrap-tagsinput.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/dropzone/dropzone.css')}}">
@endsection

@section('scripts')
    <!-- Dependencies -->
    <script src="{{ asset('assets/vendor/libs/bootstrap-select/bootstrap-select.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/bootstrap-tagsinput/bootstrap-tagsinput.js') }}"></script>
    <script src="{{asset('assets/vendor/libs/dropzone/dropzone.js')}}"></script>
@endsection

@section('content')
    <h4 class="font-weight-bold py-3 mb-4">
        Сканирование фотографий
    </h4>
    <div class="card mb-4">
        <h6 class="card-header">
            Выбор фотографий
        </h6>
        <div class="card-body">
                    <div class="cui-example">
                        <div class="form-group">
                            <label class="form-label">Укажите список фотографий которые вы хотите загрузиить</label>
                            <select class="selectpicker" data-style="btn-default" multiple data-icon-base="ion" data-tick-icon="ion-md-checkmark" name="language[]">
                                <option>Фото 3x4</option>
                                <option>Копия паспорта</option>
                                <option>Копия диплома</option>
                            </select>
                        </div>
                        <div>
                            <form action="#" class="dropzone needsclick" id="dropzone-demo">
                                <div class="dz-message needsclick">
                                   Нажмите чтобы выбрать файл
                                    <span class="note needsclick">(Здесь будут отображены ваши фотографии)</span>
                                </div>
                                <div class="fallback">
                                    <input name="file" type="file" multiple>
                                </div>
                            </form>
                        </div>
                        <!-- Javascript -->
                        <script>
                            $(function() {
                                $('#dropzone-demo').dropzone({
                                    parallelUploads: 2,
                                    maxFilesize:     50000,
                                    filesizeBase:    1000,
                                    addRemoveLinks:  true,
                                });

                                Dropzone.prototype.uploadFiles = function(files) {
                                    var minSteps         = 6;
                                    var maxSteps         = 60;
                                    var timeBetweenSteps = 100;
                                    var bytesPerStep     = 100000;

                                    var self = this;

                                    for (var i = 0; i < files.length; i++) {

                                        var file = files[i];
                                        var totalSteps = Math.round(Math.min(maxSteps, Math.max(minSteps, file.size / bytesPerStep)));

                                        for (var step = 0; step < totalSteps; step++) {
                                            var duration = timeBetweenSteps * (step + 1);

                                            setTimeout(function(file, totalSteps, step) {
                                                return function() {
                                                    file.upload = {
                                                        progress: 100 * (step + 1) / totalSteps,
                                                        total: file.size,
                                                        bytesSent: (step + 1) * file.size / totalSteps
                                                    };

                                                    self.emit('uploadprogress', file, file.upload.progress, file.upload.bytesSent);
                                                    if (file.upload.progress == 100) {

                                                        if (totalSteps) {
                                                            file.status =  Dropzone.SUCCESS;
                                                            self.emit('success', file, 'Успех', null);
                                                        } else {
                                                            file.status =  Dropzone.ERROR;
                                                            self.emit('error', file, 'Ошибка', null);
                                                        }

                                                        self.emit('complete', file);
                                                        self.processQueue();
                                                    }
                                                };
                                            }(file, totalSteps, step), duration);
                                        }
                                    }
                                };
                            });
                        </script>
                        <!-- / Javascript -->
                    </div>
        </div>

    </div>
    <input type="submit" class="btn btn-primary" value="Сканировать фото">
@endsection
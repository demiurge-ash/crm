<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Загрузка XLS-файла</div>
                <div class="card-body">

                    <div class="container">

                        <form method="POST" action="/tracking/worktime/upload" class="validateform" autocomplete="off" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <div class="custom-file" id="worktime_file" lang="ru">
                                    <input type="file"
                                           class="custom-file-input"
                                           id="worktime_file"
                                           name="worktime_file"
                                           accept=".xls,.xlsx"
                                           required
                                    >
                                    <label class="custom-file-label" for="photo">
                                        Загрузить файл...
                                    </label>
                                </div>
                            </div>
                            <div class="form-group text-right">
                                <button type="submit" class="btn btn-success" id="submit">
                                    Обработать
                                </button>
                            </div>
                        </form>

                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

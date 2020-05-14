<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">

                <div class="card-header">Графики рабочего времени</div>
                <div class="card-body">

                    <div class="container">
                        <div class="row right">
                            <div class="col">
                            </div>
                            <div class="col-4 pb-3">
                                {{--<label class="col-form-label" for="user">Фильтр</label>--}}
                                <select class="form-control select2" id="user" name="user">
                                    <option>— Все сотрудники —</option>
                                    @foreach($users as $user)
                                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <table id="tableSchedules" class="table table-striped table-bordered" style="width:100%">
                        <thead>
                        <tr>
                            <th scope="col">Сотрудник</th>
                            <th scope="col">Начиная с</th>
                            <th scope="col">Начало дня</th>
                            <th scope="col">Окончание дня</th>
                            <th scope="col">&nbsp;</th>
                        </tr>
                        </thead>
                    </table>
                </div>

            </div>
        </div>
    </div>
</div>
<br>

@section('script')

    {!! /* JS syntax highlighter !!}<script>{!! */'' !!}

        $('#user').on('change', function(e){
            datatablePasses.ajax.reload();
        });

        var datatablePasses = $('#tableSchedules').DataTable( {
                responsive: true,
                select: false,
                serverSide: true,
                processing: true,
                stateSave: false,
                ajax: {
                    "url": "/tracking/schedule/ajax",
                    "dataType": "json",
                    "type": "POST",
                    "data": function ( d ) {
                        d._token = "{{ csrf_token() }}",
                        d.user = $('#user option:selected').val();
                    }
                },
                columns: [
                    { "data": "user.name" },
                    { "data": "date" },
                    { "data": "time_begin" },
                    { "data": "time_end" },
                    { "data": function (data) {
                            return '<a href="/tracking/schedule/edit/' + data.id + '">' +
                                '<button type="submit" class="btn btn-success">' +
                                'Просмотр' +
                                ' </button>' +
                                '</a>\n';
                        }
                    }
                ],
                columnDefs: [
                    {
                        "targets": [ 4 ],
                        "visible": true,
                        "searchable": false,
                        "orderable": false,
                        "className": "text-center",
                    }
                ],
                aaSorting: [
                    [
                        0, 'asc'
                    ]
                ],
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
                    "emptyTable": "Записей нет",
                    "paginate": {
                        "first": "Первая",
                        "previous": "<",
                        "next": ">",
                        "last": "Последняя"
                    },
                    aria: {
                        "sortAscending": ": активировать для сортировки столбца по возрастанию",
                        "sortDescending": ": активировать для сортировки столбца по убыванию"
                    }
                },
            } );

@endsection
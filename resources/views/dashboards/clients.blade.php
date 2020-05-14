<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">

                <div class="card-header">Клиенты</div>
                <div class="card-body">
                    <table id="tableClients" class="table table-striped table-bordered" style="width:100%">
                        <thead>
                        <tr>
                            <th scope="col">ФИО</th>
                            <th scope="col">телефон</th>
                            <th scope="col">email</th>
                            <th scope="col">описание</th>
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

    var datatablePasses = $('#tableClients').DataTable( {
    responsive: true,
    select: false,
    serverSide: true,
    processing: true,
    stateSave: false,
    ajax: {
        "url": "/clients/ajax",
        "dataType": "json",
        "type": "POST",
        "data":{ _token: "{{ csrf_token() }}"}
    },
    columns: [
        { "data": "name" },
        { "data": "phone" },
        { "data": "email" },
        { "data": "description" },
        { "data": function (data) {
            return '<a href="/clients/' + data.id + '">' +
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
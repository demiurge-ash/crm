<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Выбор недели</div>
                <div class="card-body">

                    <div class="container">
                        <form method="POST" action="/tracking/worktime/update-week">
                            @csrf
                        <div class="row">
                            <div class="col-8 form-group text-right">
                                <div class="input-group">
                                    <input type='text'
                                           name="week"
                                           id='weeklyDatePicker'
                                           class="form-control datetimepicker-input"
                                           data-toggle="datetimepicker"
                                           data-target="#weeklyDatePicker"
                                           placeholder="Выберите неделю"
                                           value="{{ $firstDayOfWeek ?? '' }}"
                                    >
                                </div>
                            </div>
                            <div class="col text-left">
                                    <button type="submit" class="btn btn-success" id="createOrder">
                                        Выбрать неделю!
                                    </button>
                            </div>
                        </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
<br>

@push('scripts')
    $("#weeklyDatePicker").datetimepicker({
        format: 'DD-MM-YYYY',
        locale: 'ru',
    });

    $('#weeklyDatePicker').on('dp.change', function (e) {
        var value = $("#weeklyDatePicker").val();
        var firstDate = moment(value, "DD-MM-YYYY").day(1).format("DD-MM-YYYY");
        var lastDate =  moment(value, "DD-MM-YYYY").day(7).format("DD-MM-YYYY");
        $("#weeklyDatePicker").val(firstDate);
//      $("#weeklyDatePicker").val(firstDate + "," + lastDate);
    });
@endpush

@section('footer')
    <link href="/bootstrap-datetimepicker/bootstrap-datetimepicker.css" rel="stylesheet">
    <script src="/js/moment-with-locales.js"></script>
    <script src="/bootstrap-datetimepicker/bootstrap-datetimepicker.js"></script>
@endsection
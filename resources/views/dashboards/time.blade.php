<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col">
            <div class="card">
                <div class="card-header">График отсутствия сотрудников {{ $monthHuman ?? '' }}</div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-auto">
                            <a href="/tracking/absent/{{ $prevMonthLink }}" title="Предыдущий месяц"><button class="btn">&lt;</button></a>
                        </div>
                        <div class="col-1">
                            <select class="form-control" id="selected_month" name="selected_month" required>
                                @foreach($calendarMonths as $id => $monthName)
                                <option value="{{ $id }}" @if($month == $id) selected @endif >{{ $monthName }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-1">
                            <select class="form-control" id="selected_year" name="selected_year" required>
                                @foreach($calendarYears as $id => $yearName)
                                <option value="{{ $id }}" @if($year == $id) selected @endif >{{ $yearName }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-auto">
                            <a href="/tracking/absent/{{ $nextMonthLink }}" title="Следующий месяц"><button class="btn">&gt;</button></a>
                        </div>
                        <div class="col text-right form-group">
                            <button class="newevent-modal btn btn-success" data-toggle="modal" data-target="#newEvent">
                                Создать новое событие
                            </button>
                        </div>
                    </div>

                    <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th scope="col" class="text-center">Сотрудники</th>
                    @foreach($dates as $day => $weekDay)
                            <th scope="col" class="text-center @if ($weekDay == 'сб' || $weekDay == 'вс') weekend @endif ">
                                <span class="text-secondary font-weight-light">{{ $weekDay }}</span>
                                <br>
                                {{ $day }}
                            </th>
                    @endforeach
                        <th scope="col" class="text-center text-secondary font-weight-light">Отсутствовал<br>дней</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($users as $user)
                    <tr>
                        <td scope="row">{{ $user->name }}</td>
                        @foreach($dates as $day => $weekDay)
                        <td id="td-{{ $user->id }}-{{ $year }}-{{ $month }}-{{ $day }}" class="text-center @if ($weekDay == 'сб' || $weekDay == 'вс') weekend @endif "></td>
                        @endforeach
                        <td id="missing-{{ $user->id }}" scope="row" class="text-center"></td>
                    </tr>
                    @endforeach
                    </tbody>
                </table>

                <div class="row text-center">
                    @foreach($eventsTypes as $event)
                    <div class="col-2"><div class="square bg-{{ $event->color }}">{{ $event->short }}</div> — {{ $event->name }}</div>
                    @endforeach
                </div>


                </div>
            </div>
        </div>
    </div>
</div>


<!-- Bootstrap 4 Modal - New Pass -->
<div class="modal fade" id="newEvent" role="dialog" aria-labelledby="newEventLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="newPassLabel">Новое событие</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Закрыть">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <form action="/tracking/absent/store" method="post" class="form-horizontal" role="form" id="activateEventPass">
            <div class="modal-body">
                <div id="new-eventform-error"></div>
                    {{ csrf_field() }}

                    <div class="form-group">
                        <label class="col-form-label" for="new-user">Сотрудник</label>
                        <select class="form-control" id="new-user" name="user" placeholder="выберите..." required>
                            @foreach($users as $user)
                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label class="col-form-label" for="new-event">Вид события</label>
                        <select class="form-control" id="new-event" name="event" placeholder="выберите..." required>
                            <option value="0" selected>Очистить период</option>
                        @foreach($eventsTypes as $event)
                            <option value="{{ $event->id }}">{{ $event->name }}</option>
                        @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label class="col-form-label" for="date_begin_event">Начальная дата</label>
                        <input type="date" class="form-control" id="date_begin_event" name="date_begin" required>
                    </div>

                    <div class="form-group">
                        <label class="col-form-label" for="date_end_event">Конечная дата</label>
                        <input type="date" class="form-control" id="date_end_event" name="date_end" required>
                    </div>

            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Отмена</button>
                <button type="submit" class="btn btn-success" id="new-activateButton">Создать событие</button>
            </div>

            </form>

        </div>
    </div>
</div>

@push('scripts')
    {!! /* JS syntax highlighter !!}<script>{!! */'' !!}

    eventsType = {
        @foreach( $eventsTypes as $type)
         {{ $type->id }}: '{{ $type->short }}',
        @endforeach
        };
        eventsColor = {
        @foreach( $eventsTypes as $type)
        {{ $type->id }}: '{{ $type->color }}',
        @endforeach
    };

    var events = @json($events);
    if (events) {
        $.each(events, function(i, item) {
            $('#td-'+events[i].user_id+'-'+events[i].date).addClass('bg-'+eventsColor[events[i].event]);
            $('#td-'+events[i].user_id+'-'+events[i].date).html(eventsType[events[i].event]);
        });
    }

    var workdays = @json($workDays);
    if (workdays) {
        $.each(workdays, function(i, item) {
            $('#td-'+workdays[i].user_id+'-'+workdays[i].date).addClass('bg-white');
            $('#td-'+workdays[i].user_id+'-'+workdays[i].date).html('Р');
        });
    }

    var days = @json($days);
    var users = @json($users);
    if (users) {
        $.each(users, function(id) {
            missedDays = 0;
            $.each(days, function(i) {
                column = $('#td-'+users[id].id+'-'+days[i]).html();
                if (!column) missedDays++;
            });
            $('#missing-'+users[id].id).html(missedDays);
        });
    }

    // Create new event. Check dates
    $('#date_begin_event').on('change paste keyup', function (e) {
        minDate = $(this).val();
        $('#date_end_event').attr("min", minDate);
    });

    $('#date_end_event').on('change paste keyup', function (e) {
        minDate = $(this).val();
        $('#date_begin_event').attr("max", minDate);
    });


    $('#selected_month').on('change', function (e) {
        changePeriod();
    });
    $('#selected_year').on('change', function (e) {
        changePeriod();
    });

    function changePeriod() {
        month = $('#selected_month').val();
        year = $('#selected_year').val();
        window.location.href = "/tracking/absent/"+year+'/'+month;
    }

@endpush

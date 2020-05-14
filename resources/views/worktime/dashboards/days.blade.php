<div class="container">
    <div class="row justify-content-center">
        <div class="col">

            @foreach($days as $day => $users)
            <div class="card">
                <div class="card-header"><b>{{ Jenssegers\Date\Date::parse($day)->format('j F Y, l') }}</b></div>
                <div class="card-body">

                    <table class="table table-bordered table-striped">
                        <thead>
                        <tr>
                            <td scope="col" class="text-center font-weight-light">Сотрудники</td>
                            <td scope="col" class="text-center font-weight-light">Приход</td>
                            <td scope="col" class="text-center font-weight-light">Уход</td>
                            <td scope="col" class="text-center font-weight-light">Норма</td>
                            <td scope="col" class="text-center font-weight-light">Опоздание</td>
                            <td scope="col" class="text-center font-weight-light">Ушел раньше</td>
                            <td scope="col" class="text-center font-weight-light">Недоработал</td>
                            <td scope="col" class="text-center font-weight-light">Переработал</td>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($users as $user)
                            <tr>
                                <td scope="row">{{ $user->name }}</td>
                                <td scope="row" class="text-center">{{ $user->worktime_in ?? '—' }}</td>
                                <td scope="row" class="text-center">{{ $user->worktime_out ?? '—' }}</td>
                                <td scope="row" class="text-center">{{ $user->work_time_begin }} — {{ $user->work_time_end }}</td>
                                <td scope="row" class="text-center {{ $user->worktime_lateness_color ?? '' }}">{{ $user->worktime_lateness ?? '—' }}</td>
                                <td scope="row" class="text-center {{ $user->worktime_early_color ?? '' }}">{{ $user->worktime_early ?? '—' }}</td>
                                <td scope="row" class="text-center {{ $user->worktime_debt_color ?? '' }}">{{ $user->worktime_debt ?? '—' }}</td>
                                <td scope="row" class="text-center {{ $user->worktime_over_color ?? '' }}">{{ $user->worktime_over ?? '—' }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>

                </div>
            </div>
            <br>
            @endforeach

        </div>
    </div>
</div>
<br>
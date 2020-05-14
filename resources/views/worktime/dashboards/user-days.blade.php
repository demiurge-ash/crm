<div class="container">
    <div class="row justify-content-center">
        <div class="col">

            <div class="card">
                <div class="card-header"><b>{{ $currentUser->name }}</b>, <i class="text-secondary font-weight-light">{{ $currentUser->role->display_name }}</i></div>
                <div class="card-body">

                    <table class="table table-bordered table-striped">
                        <thead>
                        <tr>
                            <td scope="col" class="text-center font-weight-light">День</td>
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
                        @foreach($days as $day => $user)
                            <tr>
                                <td scope="row" class="text-center">{{ Jenssegers\Date\Date::parse($day)->format('j F Y, D') }}</td>
                                <td scope="row" class="text-center">{{ $user->worktime_in ?? '—' }}</td>
                                <td scope="row" class="text-center">{{ $user->worktime_out ?? '—' }}</td>
                                <td scope="row" class="text-center">{{ $user->work_time_begin }} — {{ $user->work_time_end }}</td>
                                <td scope="row" class="text-center {{ $user->worktime_lateness_color ?? '' }}">{{ $user->worktime_lateness ?? '—' }}</td>
                                <td scope="row" class="text-center {{ $user->worktime_early_color ?? '' }}">{{ $user->worktime_early ?? '—' }}</td>
                                <td scope="row" class="text-center {{ $user->worktime_debt_color ?? '' }}">{{ $user->worktime_debt ?? '—' }}</td>
                                <td scope="row" class="text-center {{ $user->worktime_over_color ?? '' }}">{{ $user->worktime_over ?? '—' }}</td>
                            </tr>
                        @endforeach
                        <tr>
                            <td scope="row" class="text-center font-weight-bold">{{ $stats['days'] }}</td>
                            <td scope="row" class="text-center font-weight-bold"></td>
                            <td scope="row" class="text-center font-weight-bold"></td>
                            <td scope="row" class="text-center font-weight-bold"></td>
                            <td scope="row" class="text-center font-weight-bold {{ $stats['worktime_lateness_color'] ?? 'text-danger' }}">{{ $stats['worktime_lateness'] }}</td>
                            <td scope="row" class="text-center font-weight-bold {{ $stats['worktime_early_color'] ?? 'text-danger' }}">{{ $stats['worktime_early'] }}</td>
                            <td scope="row" class="text-center font-weight-bold {{ $stats['worktime_debt_color'] ?? 'text-danger' }}">{{ $stats['worktime_debt'] }}</td>
                            <td scope="row" class="text-center font-weight-bold {{ $stats['worktime_over_color'] ?? 'text-success' }}">{{ $stats['worktime_over'] }}</td>
                        </tr>
                        </tbody>
                    </table>

                </div>
            </div>
            <br>

        </div>
    </div>
</div>
<br>
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col">
            <div class="card">
                <div class="card-header">
                    Заполнение времени входа-выхода сотрудников за неделю №{{ $date->week() }}.
                </div>
                <div class="card-body">

                    <div class="container-fluid">
                        <form method="POST" action="/tracking/worktime/store">
                            @csrf
                            <input type="hidden" name="week" value="{{ $week ?? '' }}">
                            <div class="row">

                                <table class="table table-bordered table-striped">
                                    <thead>
                                    <tr>
                                        <td scope="col" class="text-center font-weight-light"></td>
                                        @foreach($dates as $day => $weekDay)
                                            <th colspan=2 scope="col" class="text-center {{--@if ($weekDay == 'сб' || $weekDay == 'вс') weekend @endif--}} ">
                                                <span class="text-secondary font-weight-light">{{ $weekDay }}</span> {{ $day }}
                                            </th>
                                        @endforeach
                                    </tr>
                                    <tr>
                                        <td scope="col" class="text-center font-weight-light">Сотрудники</td>
                                        @foreach($dates as $day => $weekDay)
                                            <th scope="col" class="font-weight-light text-center {{--@if ($weekDay == 'сб' || $weekDay == 'вс') weekend @endif--}} ">
                                                Приход
                                            </th>
                                            <th scope="col" class="font-weight-light text-center {{--@if ($weekDay == 'сб' || $weekDay == 'вс') weekend @endif--}} ">
                                                Уход
                                            </th>
                                        @endforeach
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($users as $user)
                                        <tr>
                                            <td scope="row">{{ $user->name }}</td>
                                            @foreach($dates as $day => $weekDay)
                                                <td scope="col" class="text-center @{{--if ($weekDay == 'сб' || $weekDay == 'вс') weekend @endif--}} ">
                                                    <input name="worktime-in-{{ $user->id }}-{{ $day }}" type="time">
                                                </td>
                                                <td scope="col" class="text-center {{--@if ($weekDay == 'сб' || $weekDay == 'вс') weekend @endif--}} ">
                                                    <input name="worktime-out-{{ $user->id }}-{{ $day }}" type="time">
                                                </td>
                                            @endforeach
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>

                            </div>

                            <div class="row">
                                <div class="col text-right">
                                    <button type="submit" class="btn btn-success">
                                        Отправить!
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

@push('scripts')

    @foreach($fields as $name => $value)
        $("[name='{{ $name }}']").val('{!! addslashes($value) !!}');
    @endforeach

@endpush
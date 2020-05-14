<table class="table table-bordered" id="radioPeriods" style="width: 97%">
    <thead>
    <tr>
        <th scope="col" class="text-center">Время<br><br></th>
        <th scope="col" class="text-center">
            <span class="text-secondary font-weight-light">Стоимость</span>
            <br>
            пн-пт/вых
        </th>
        @foreach($radioDays as $day => $weekDay)
            <th scope="col" class="text-center @if ($weekDay == 'сб' || $weekDay == 'вс') weekend @endif ">
                <span class="text-secondary font-weight-light">{{ $weekDay }}</span>
                <br>
                {{ Carbon\Carbon::parse($day)->format('d') }}
            </th>
        @endforeach
    </tr>
    </thead>
    <tbody>
    @foreach($periods as $period)
        <tr>
            <td scope="row" class="text-center">{{ $period->begin }}-{{ $period->end }}</td>
            <td scope="row" class="text-center">{{ $period->price }}/{{ $period->price_weekends }}</td>
            @foreach($radioDays as $day => $weekDay)
                <td id="td-{{ $period->id }}-{{ $day }}"
                    class="editMe text-center radio-period-cell @if ($weekDay == 'сб' || $weekDay == 'вс') weekend @endif"></td>
            @endforeach
        </tr>
    @endforeach
    </tbody>
</table>

<input type='hidden' name='radio-periods' id='radio-periods' value=''>

<br>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">

                <div class="card-header">График рабочих дней</div>
                <div class="card-body">
                    <div id="my-calendar"></div>
                </div>

            </div>
        </div>
    </div>
</div>
<br>

@push('scripts')

        @if($user->working_days)
                @php $workingDaysArray = explode(',', $user->working_days)@endphp
            workingDays = [ @foreach($workingDaysArray as $day) new Date('{{ $day }}T21:00:00.000Z'),
            @endforeach ];
        @else
            workingDays = [];
        @endif

        var myDatepicker = $('#my-calendar').datepicker({
            multipleDates: true,
            timeFormat: null,
            dateFormat: 'yyyy-mm-dd',
            onRenderCell: function () { return { disabled: true } },
        }).data('datepicker');
        myDatepicker.selectDate(workingDays);
        myDatepicker.date = new Date();

@endpush
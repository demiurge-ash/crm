<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">

                <div class="card-header">График отпусков</div>
                <div class="card-body">
                    @if ($vacationsPeriods && count($vacationsPeriods))
                        @foreach ($vacationsPeriods as $item)
                            <p class="card-text">
                                {{ $item }}
                            </p>
                        @endforeach
                    @else
                        У вас нет запланированных отпусков
                    @endif
                </div>

            </div>
        </div>
    </div>
</div>
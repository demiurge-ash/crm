<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-4">
            <div class="card">

                <div class="card-header">Редактирование графика рабочего времени</div>
                <div class="card-body">

                    <div class="col">
                        <form class="form-horizontal" method="post" action="{{ route('timeschedule-update') }}" role="form">
                            @csrf
                            <input hidden name="id"  value="{{ $current->id ?? '' }}">

                            @include('schedule.dashboards.form-schedule')

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<br>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-4">
            <div class="card">

                <div class="card-header">Добавление графика рабочего времени</div>
                <div class="card-body">
                    <div class="col">
                        <form class="form-horizontal" method="post" action="{{ route('timeschedule-store') }}" role="form">
                            @csrf

                            @include('schedule.dashboards.form-schedule')

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<br>
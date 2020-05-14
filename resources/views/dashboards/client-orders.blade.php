<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">

                <div class="card-header">Список заказов клиента</div>
                <div class="card-body">

                    @if( ! empty($orders) && count($orders))
                        @include('templates.order-table')
                    @else
                        <span class="text-secondary">заказов не найдено</span>
                    @endif

                </div>

            </div>
        </div>
    </div>
</div>
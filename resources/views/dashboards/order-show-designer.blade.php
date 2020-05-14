<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">

                <div class="card-header">Заказ №{{ $order->order_id }}</div>
                <div class="card-body">

                    <h5 class="card-subtitle mb-2 text-muted">Дата заказа</h5>
                    <li class="list-group-item">{{ $order->order_date_human }}</li>
                    <br>

                    <h5 class="card-subtitle mb-2 text-muted">Размер, мм</h5>
                    <li class="list-group-item">{{ $order->width }} х {{ $order->height }}</li>
                    <br>

                    <h5 class="card-subtitle mb-2 text-muted">Тип</h5>
                    <li class="list-group-item">{{ $order->size_name }}</li>
                    <br>

                    <h5 class="card-subtitle mb-2 text-muted">Приложенный файл</h5>
                    <li class="list-group-item">{!! $order->file_link ?? 'не загружен' !!}</li>
                    <br>

                    @if($order->designer_file)
                    <h5 class="card-subtitle mb-2 text-muted">Готовый макет</h5>
                    <li class="list-group-item">{!! $order->designer_file_link !!}</li>
                    <br>
                    @endif

                    <h5 class="card-subtitle mb-2 text-muted">Техническое задание</h5>
                    <li class="list-group-item">{{ $order->text ?? '...' }}</li>
                    <br>

                    <h5 class="card-subtitle mb-2 text-muted">Правки</h5>
                    <li class="list-group-item">{{ $order->edits ?? '...' }}</li>
                    <br>

                </div>

            </div>
        </div>
    </div>
</div>
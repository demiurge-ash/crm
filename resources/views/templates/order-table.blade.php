@if( ! empty($orders) && count($orders))
    <div class="table-responsive">

        <div class="form-check pb-3 text-right">
            <input type="checkbox" class="form-check-input" name="unfinished" id="unfinished" value="1">
            <label class="form-check-label text-secondary" for="unfinished">только незавершенные заказы</label>
        </div>

        <table id="ordersTable" class="table table-striped" data-page-length='25'>
            <thead>
            <tr>
                <th>№</th>
                <th>Тип заказа</th>
                <th class="text-center">Дата</th>
                <th class="text-center">Статус</th>
                <th>&nbsp;</th>
            </tr>
            </thead>
            <tbody>

            @foreach($orders as $order)
                <tr class="{!! \App\Helpers\Status::getOrderStatus($order) !!}">
                    <td>{{ $order->order_id }}</td>
                    <td>{{ $order->category }}</td>
                    <td class="text-center">{{ \App\Helpers\Helpers::humanDate($order->order_date) }}</td>
                    <td class="text-center">{!! \App\Helpers\Status::workStatus($order) !!}</td>
                    <td class="text-right">

                        @if(\Auth::user()->isOnlyBoss())
                            <a href="/order/delete/{{ $order->order_id }}"
                               onclick="return confirm('Вы уверены, что хотите удалить этот заказ?');">
                                <button type="button" class="btn btn-danger btn-sm">удалить</button>
                            </a>
                        @endif

                        @if(\Auth::user()->isDesigner())
                            <a href="/order/show/{{ $order->order_id }}">
                                <button type="button" class="btn btn-light btn-sm">просмотр</button>
                            </a>
                        @else
                            <a href="/order/edit/{{ $order->order_id }}">
                                <button type="button" class="btn btn-light btn-sm">просмотр</button>
                            </a>
                        @endif

                    </td>
                </tr>
            @endforeach

            </tbody>
        </table>
    </div>

@else

    <div class="text-center">
        На выбранные даты заказов не было
    </div>

@endif

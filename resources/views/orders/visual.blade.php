<div class="tab-content">
    <!--    Визуальная  -->
    <div id="visual" class="fade in active">

        @include('templates.bypass')

        @include('orders.production-types')

        @include('orders.design', ['type' => ""])

        @include('orders.production')

        @include('orders.placement')

        @include('orders.montage', ['type' => ""])

        <div class="row">
            <div class="col-xs-11 text-right total-page">
                <strong>Итого: </strong>@{{ visual_abs_price }} руб.
            </div>
        </div>

    </div>
    <!--    /Визуальная  -->
</div>

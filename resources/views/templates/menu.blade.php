<!--    вкладки -->
<div class="tabs-color">
    @if (empty($current->order_id))

    <ul class="nav nav-tabs nav-tabs_order">
        <li class="col-xs-6 col-sm-6 col-md-2 {{ $visual ?? '' }}">
            <a href="/order">
                Визуальная
            </a>
        </li>
        <li class="col-xs-6 col-sm-6 col-md-2 {{ $promo ?? '' }}">
            <a href="/order/promo">
                Промо
            </a>
        </li>
        <li class="col-xs-6 col-sm-6 col-md-2 {{ $photo ?? '' }}">
            <a href="/order/photo">
                Фотосъемка
            </a>
        </li>
        <li class="col-xs-6 col-sm-6 col-md-2 {{ $radio ?? '' }}">
            <a href="/order/radio">
                Радио
            </a>
        </li>
{{--        <li class="col-xs-6 col-sm-6 col-md-2 {{ $entry ?? '' }}">
            <a href="/order/bypass-entry">
                Обходной
            </a>
        </li>--}}
    </ul>
    @else
        <hr>
    @endif


</div>
<!--    /вкладки -->

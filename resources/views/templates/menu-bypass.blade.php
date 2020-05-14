@if (empty($current->order_id))
<!--    вкладки -->
<div class="row">
    <div class="col-xs-12">
        <div class="tabs-color">
            <ul class="nav nav-tabs nav-tabs_order subnav-tabs_order">
                <li class="col-xs-6 col-sm-6 col-md-2 {{ $entry ?? '' }}">
                    <a href="/order/bypass-entry">
                        Въезд
                    </a>
                </li>
                <li class="col-xs-6 col-sm-6 col-md-2 {{ $departure ?? '' }}">
                    <a href="/order/bypass-departure">
                        Выезд
                    </a>
                </li>
                <li class="col-xs-6 col-sm-6 col-md-2 {{ $replacement ?? '' }}">
                    <a href="/order/bypass-replacement">
                        Замена
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>
@endif
<hr class="full blue">

<div id="order-errors"></div>
<div class="row margin-bottom">
    <div class="col-xs-6 col-sm-6 col-md-2">

        @if( (\Auth::user()->isOnlyBoss()) && (! empty($current->order_id)))
            <a href="/order/delete/{{ $current->order_id }}"
               onclick="return confirm('Вы уверены, что хотите удалить этот заказ?');">
                {{--<button type="button" class="btn btn-danger btn-sm">удалить</button>--}}
                <button type="button" class="btn btn-danger">
                    Удалить заказ
                </button>
            </a>
        @endif

    </div>
    <div class="col-xs-6 col-sm-6 col-md-3">
        <button type="button" class="btn btn-green btn-reset">
            Очистить форму
        </button>
    </div>
    <div class="col-xs-6  col-sm-6 col-md-3">
        <button type="button" class="btn btn-green">
            Печатать чек
        </button>
    </div>
    <div class="col-xs-6 col-sm-6 col-md-3">
        <button type="submit" class="btn btn-green" id="submit">
            Сохранить
        </button>
    </div>
</div>


</div>
<!--  container  -->

</form>
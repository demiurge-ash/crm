<div class="tab-content">

<!--    Промо  -->
<div id="promo" class="fade in active">
    <div class="row">
        <div class="col-xs-6 col-sm-3 col-md-3">
            <div class="form-group">
                <label class="control-label">Дата оплаты</label>
                <div class="input-group datetimepicker" id="datepayment">
                    <input type="datetime"
                           class="form-control date-now-paid"
                           name="promo-date-payment"
                           id="promo-date-payment"
                           readonly
                    >
                    <span class="input-group-addon">
                        <span class="glyphicon glyphicon-calendar cursor-disabled"></span>
                    </span>
                </div>
            </div>
        </div>
        <div class="col-xs-6 col-sm-3 col-md-3">
            <div class="form-group">
                <label class="control-label" for="promocost">Стоимость</label>
                <input type="number"
                       step="0.01"
                       class="form-control"
                       id="promocost"
                       name="promo-cost-payment"
                       v-model="promo_cost_payment"
                       v-restrict.number.decimal
                >
            </div>
        </div>
        <div class="col-xs-6 col-sm-3 col-md-3">
            <div class="form-group">
                <label class="control-label" for="promoquantity">Количество дней</label>
                <input type="number"
                       class="form-control"
                       id="promoquantity"
                       name="promo-quantity-payment"
                       v-restrict.number
                >
            </div>
        </div>
    </div>

    <div class="row margin-bottom">
        <div class="col-xs-6 col-sm-3 col-md-3">
            <label class="radio-inline">
                <input type="radio"
                       name="promo-paid"
                       value="1"
                       class=" input-group-lg"
                       @click="setDateNow('#promo-date-payment')"
                >
                Оплачено
            </label>
        </div>
        <div class="col-xs-6 col-sm-3 col-md-3">
            <label class="radio-inline">
                <input type="radio"
                       name="promo-paid"
                       value="0"
                       @click="clearField('#promo-date-payment')"
                >
                Не оплачено
            </label>
        </div>
    </div>


    <!--    Компания    -->
    <div class="row">
        <div class="col-xs-12 col-sm-4 col-md-3">
            <div class="form-group">
                <label class="control-label" for="promocompany">Компания</label>
                <input type="text"
                       id="promocompany"
                       name="promo-company"
                       class="form-control"
                       list="promocompany-list">
                @if( ! empty($companies) && count($companies))
                    <datalist id="promocompany-list">
                        @foreach($companies as $item)
                            <option value="{{ $item->name }}"
                                    id="promocompany-{{ $item->id }}"
                            >
                        @endforeach
                    </datalist>
                @endif

            </div>
        </div>
        <div class="col-xs-6 col-sm-4 col-md-3">
            <div class="form-group">
                <label class="control-label">Дата начала</label>
                <div class="input-group datetimepicker">
                    <input type="datetime" class="form-control date-now" name="promo-company-date-begin">
                    <span class="input-group-addon">
                        <span class="glyphicon glyphicon-calendar"></span>
                    </span>
                </div>
            </div>
        </div>
        <div class="col-xs-6 col-sm-4 col-md-3">
            <div class="form-group">
                <label class="control-label">Дата конца</label>
                <div class="input-group datetimepicker">
                    <input type="datetime" class="form-control" name="promo-company-date-end">
                    <span class="input-group-addon">
                        <span class="glyphicon glyphicon-calendar"></span>
                    </span>
                </div>
            </div>
        </div>
    </div>
    <!--    /Компания    -->

    <div id="multi-promoter" class="multifield">
    <div id="multi-promoter-group">

    @if( ! empty($current->promoters) && count($current->promoters))

    @foreach($current->promoters as $currentPromoter)
        @php
        $cID = $currentPromoter->sorting_order;
        @endphp
    <!--    Промоутер    -->
    <div class="row multi-promoter-elem">
        <div class="col-xs-12 col-sm-3 col-md-3">
            <div class="form-group">
                <label class="control-label">Промоутер</label>
                <input type="text"
                       {{-- id="promoter-{{ $cID }}" --}}
                       name="promoter-number-{{ $cID }}"
                       class="form-control"
                       value="{{ $currentPromoter->promoter ?? '' }}"
                       list="promoter-list">
                @if( ! empty($promoters) && count($promoters))
                    <datalist id="promoter-list">
                        @foreach($promoters as $item)
                            <option value="{{ $item->name }}"
                                    id="promoter-{{ $item->id }}"
                            >
                        @endforeach
                    </datalist>
                @endif

{{--                <select class="form-control multiprotect" name="promoter-number-{{ $cID }}">
                    @foreach($promoters as $item)
                        <option value="{{ $item->id }}"
                                @if($currentPromoter->promoter == $item->id)
                                selected
                                @endif
                        >{{ $item->name }}</option>
                    @endforeach
                </select>--}}

            </div>
        </div>

        <div class="col-xs-6 col-sm-3 col-md-3">
            <div class="form-group">
                <label class="control-label">Дата начала</label>
                <div class="input-group datetimepicker" id="promopromoterdatebeging{{ $cID }}">
                    <input type="datetime"
                           class="form-control multiprotect"
                           placeholder=""
                           value="{{ $currentPromoter->date_begin ?? '' }}"
                           name="promoter-date-begin-{{ $cID }}">
                    <span class="input-group-addon">
                        <span class="glyphicon glyphicon-calendar"></span>
                    </span>
                </div>
            </div>
        </div>
        <div class="col-xs-6 col-sm-3 col-md-3">
            <div class="form-group">
                <label class="control-label">Дата конца</label>
                <div class="input-group datetimepicker" id="promopromoterdataend{{ $cID }}">
                    <input type="datetime"
                           class="form-control"
                           placeholder=""
                           value="{{ $currentPromoter->date_end ?? '' }}"
                           name="promoter-date-end-{{ $cID }}">
                    <span class="input-group-addon">
                        <span class="glyphicon glyphicon-calendar"></span>
                    </span>
                </div>
            </div>
        </div>

        <div class="col-xs-12 col-sm-3 col-md-3">
            <!--    паспорт -->
            <div class="row">
                <div class="col-xs-6 col-sm-5">
                    <div class="form-group">
                        <label class="control-label">&nbsp;</label>
                        <div class="input-group">
                            <button type="button" class="btn btn-danger btnRemove-promoter">Удалить</button>
                        </div>

                        <!--
                                                <label class="control-label"
                                                       for="photographerpassportserial1">Паспорт</label>
                                                <input type="text"
                                                       class="form-control"
                                                       id="promopromoterpassportserial1"
                                                       placeholder="Серия"
                                                       minlength="4"
                                                       maxlength="4"
                                                       name="promoter-passport-serial-1"
                                                >
                        -->
                    </div>
                </div>
                <div class="col-xs-6 col-sm-7">
                    <div class="form-group">
                        <!--
                                                <label class="control-label" for="photographerpassportnumber1">Номер</label>
                                                <input type="text"
                                                       class="form-control"
                                                       id="promopromoterpassportnumber1"
                                                       placeholder="Номер"
                                                       name="promoter-passport-number-1"
                                                >
                        -->
                    </div>
                </div>
            </div>
            <!--    /паспорт -->

        </div>
    </div>
    @endforeach

    @else

    <!--    Промоутер    -->
    <div class="row multi-promoter-elem">
        <div class="col-xs-12 col-sm-3 col-md-3">
            <div class="form-group">
                <label class="control-label">Промоутер</label>
                <input type="text"
                       name="promoter-number-1"
                       class="form-control"
                       list="promoter-list">
                @if( ! empty($promoters) && count($promoters))
                    <datalist id="promoter-list">
                        @foreach($promoters as $item)
                            <option value="{{ $item->name }}"
                                    id="promoter-{{ $item->id }}"
                            >
                        @endforeach
                    </datalist>
                @endif

{{--                @if( ! empty($promoters) && count($promoters))
                <select class="form-control multiprotect" name="promoter-number-1">
                    @foreach($promoters as $item)
                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                    @endforeach
                </select>
                @endif--}}

            </div>
        </div>
        <div class="col-xs-6 col-sm-3 col-md-3">
            <div class="form-group">
                <label class="control-label">Дата начала</label>
                <div class="input-group datetimepicker" id="promopromoterdatebeging1">
                    <input type="datetime" class="form-control date-now multiprotect" placeholder="" name="promoter-date-begin-1">
                    <span class="input-group-addon">
                        <span class="glyphicon glyphicon-calendar"></span>
                    </span>
                </div>
            </div>
        </div>
        <div class="col-xs-6 col-sm-3 col-md-3">
            <div class="form-group">
                <label class="control-label">Дата конца</label>
                <div class="input-group datetimepicker" id="promopromoterdataend1">
                    <input type="datetime" class="form-control" placeholder="" name="promoter-date-end-1">
                    <span class="input-group-addon">
                        <span class="glyphicon glyphicon-calendar"></span>
                    </span>
                </div>
            </div>
        </div>

        <div class="col-xs-12 col-sm-3 col-md-3">
            <!--    паспорт -->
            <div class="row">
                    <div class="form-group">
                        <label class="control-label">&nbsp;</label>
                        <div class="input-group">
                            <button type="button" class="btn btn-danger btnRemove-promoter">Удалить</button>
                        </div>

                        <!--
                        <label class="control-label"
                               for="photographerpassportserial1">Паспорт</label>
                        <input type="text"
                               class="form-control"
                               id="promopromoterpassportserial1"
                               placeholder="Серия"
                               minlength="4"
                               maxlength="4"
                               name="promoter-passport-serial-1"
                        >
-->

                    </div>
                    <div class="form-group">
<!--
                        <label class="control-label" for="photographerpassportnumber1">Номер</label>
                        <input type="text"
                               class="form-control"
                               id="promopromoterpassportnumber1"
                               placeholder="Номер"
                               name="promoter-passport-number-1"
                        >
-->
                    </div>
            </div>
            <!--    /паспорт -->

        </div>
    </div>
    <!--    /Промоутер    -->

    @endif
    </div>

        <div class="row">
            <div class="col-xs-6 col-sm-4 col-md-3">
                <br>
                <button type="button" class="btn btn-light" id="btnAdd-promoter">
                    Добавить промоутера
                </button>
            </div>
        </div>

    </div>

    <div class="row">
        <div class="col-xs-6 col-sm-4 col-md-3">
            <br>
            <a href="#" type="button" class="btn btn-light">
                Печать разрешения
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-xs-11 text-right total-page">
            <strong>Итого:</strong> @{{ promo_abs_price }} руб.
        </div>
    </div>

</div>
<!--    /Промо  -->
</div>
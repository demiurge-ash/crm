<div class="tab-content">
<!--    Фотосъемка  -->
<div id="photo" class="fade in active">
    <div class="row">
        <div class="col-xs-6 col-sm-3 col-md-3">
            <div class="form-group">
                <label class="control-label">Дата оплаты</label>
                <div class="input-group datetimepicker" id="datepayment1">
                    <input type="datetime"
                           class="form-control date-now-paid"
                           name="photo-date-payment"
                           id="photo-date-payment"
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
                <label class="control-label" for="cost">Стоимость</label>
                <input type="number"
                       step="0.01"
                       class="form-control"
                       id="cost"
                       name="photo-cost"
                       v-model="photo_cost_payment"
                       v-restrict.number.decimal
                >
            </div>
        </div>
        <div class="col-xs-6 col-sm-3 col-md-3">
            <div class="form-group">
                <label class="control-label" for="period">Количество дней</label>
                <input type="number"
                       class="form-control"
                       id="period"
                       name="photo-period"
                       v-restrict.number
                >
            </div>
        </div>
    </div>

    <div class="row margin-bottom">
        <div class="col-xs-6 col-sm-3 col-md-3">
            <label class="radio-inline">
                <input type="radio"
                       name="photo-paid"
                       value="1"
                       class="input-group-lg"
                       @click="setDateNow('#photo-date-payment')"
                >
                Оплачено
            </label>
        </div>
        <div class="col-xs-6 col-sm-3 col-md-3">
            <label class="radio-inline">
                <input type="radio"
                       name="photo-paid"
                       value="0"
                       @click="clearField('#photo-date-payment')"
                >
                Не оплачено
            </label>
        </div>
    </div>

    <!--    Компания    -->
    <div class="row">
        <div class="col-xs-12 col-sm-3 col-md-3">
            <div class="form-group">
                <label class="control-label" for="photocompany">Компания</label>
                <input type="text"
                       id="photocompany"
                       name="photo-company"
                       class="form-control"
                       list="photocompany-list">
                @if( ! empty($companies) && count($companies))
                    <datalist id="photocompany-list">
                        @foreach($companies as $item)
                            <option value="{{ $item->name }}"
                                    id="photocompany-{{ $item->id }}"
                            >
                        @endforeach
                    </datalist>
                @endif
            </div>
        </div>
        <div class="col-xs-6 col-sm-3 col-md-3">
            <div class="form-group">
                <label class="control-label">Дата начала</label>
                <div class="input-group datetimepicker">
                    <input type="datetime" class="form-control date-now" name="photo-company-date-begin">
                    <span class="input-group-addon">
                        <span class="glyphicon glyphicon-calendar"></span>
                    </span>
                </div>
            </div>
        </div>
        <div class="col-xs-6 col-sm-3 col-md-3">
            <div class="form-group">
                <label class="control-label">Дата конца</label>
                <div class="input-group datetimepicker">
                    <input type="datetime" class="form-control"  name="photo-company-date-end">
                    <span class="input-group-addon">
                        <span class="glyphicon glyphicon-calendar"></span>
                    </span>
                </div>
            </div>
        </div>
    </div>
    <!--    /Компания    -->

    <div class="multifield" id="multi-photographer">
    <div id="multi-photographer-group">

    @if( ! empty($current->photograpers) && count($current->photograpers))
        @foreach($current->photograpers as $currentPhotographer)
            @php
                $cID = $currentPhotographer->sorting_order;
            @endphp

    <!--    фотограф    -->
    <div class="row multi-photographer-elem">
        <div class="col-xs-12 col-sm-3 col-md-3">
            <div class="form-group">
                <label class="control-label">Фотограф</label>
                <input type="text"
                       {{-- id="promoter-{{ $cID }}" --}}
                       name="photographer-number-{{ $cID }}"
                       class="form-control"
                       value="{{ $currentPhotographer->photographer ?? '' }}"
                       list="photographer-list">
                @if( ! empty($photographers) && count($photographers))
                    <datalist id="photographer-list">
                        @foreach($photographers as $item)
                            <option value="{{ $item->name }}"
                                    id="photographer-{{ $item->id }}"
                            >
                        @endforeach
                    </datalist>
                @endif

{{--                @if( ! empty($photographers) && count($photographers))
                <select class="form-control multiprotect" name="photographer-number-{{ $cID }}">
                    @foreach($photographers as $item)
                    <option id="photographers-{{ $item->id }}"
                            value="{{ $item->id }}"
                            @if($currentPhotographer->photographer == $item->id)
                            selected
                            @endif
                        >{{ $item->name }}</option>
                    @endforeach
                </select>
                @endif--}}

            </div>
        </div>
        <div class="col-xs-6 col-sm-3 col-md-3">
            <div class="form-group">
                <label class="control-label">Дата начала</label>
                <div class="input-group datetimepicker">
                    <input type="datetime"
                           class="form-control multiprotect"
                           placeholder=""
                           value="{{ $currentPhotographer->date_begin ?? '' }}"
                           name="photographer-date-begin-{{ $cID }}">
                    <span class="input-group-addon">
                        <span class="glyphicon glyphicon-calendar"></span>
                    </span>
                </div>
            </div>
        </div>
        <div class="col-xs-6 col-sm-3 col-md-3">
            <div class="form-group">
                <label class="control-label">Дата конца</label>
                <div class="input-group datetimepicker">
                    <input type="datetime"
                           class="form-control"
                           placeholder=""
                           value="{{ $currentPhotographer->date_end ?? '' }}"
                           name="photographer-data-end-{{ $cID }}">
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
                            <button type="button" class="btn btn-danger btnRemove-photographer">Удалить</button>
                        </div>
<!--
                        <label class="control-label">Паспорт</label>
                        <input type="text"
                               class="form-control"
                               placeholder="Серия"
                               minlength="4"
                               maxlength="4"
                               name="photographer-passport-serial-1"
                        >
-->
                    </div>
                </div>
                <div class="col-xs-6 col-sm-7">
                    <div class="form-group">
<!--
                        <label class="control-label">Номер</label>
                        <input type="text"
                               class="form-control"
                               placeholder="Номер"
                               name="photographer-passport-number-1"
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

        <!--    фотограф    -->
            <div class="row multi-photographer-elem">
                <div class="col-xs-12 col-sm-3 col-md-3">
                    <div class="form-group">
                        <label class="control-label">Фотограф</label>
                        <input type="text"
                               name="photographer-number-1"
                               class="form-control"
                               list="photographer-list">
                        @if( ! empty($photographers) && count($photographers))
                            <datalist id="photographer-list">
                                @foreach($photographers as $item)
                                    <option value="{{ $item->name }}"
                                            id="photographer-{{ $item->id }}"
                                    >
                                @endforeach
                            </datalist>
                        @endif

{{--                        @if( ! empty($photographers) && count($photographers))
                            <select class="form-control multiprotect" name="photographer-number-1">
                                @foreach($photographers as $item)
                                    <option id="photographers-{{ $item->id }}"
                                            value="{{ $item->id }}"
                                    >{{ $item->name }}</option>
                                @endforeach
                            </select>
                        @endif--}}

                    </div>
                </div>
                <div class="col-xs-6 col-sm-3 col-md-3">
                    <div class="form-group">
                        <label class="control-label">Дата начала</label>
                        <div class="input-group datetimepicker">
                            <input type="datetime" class="form-control date-now multiprotect" placeholder="" name="photographer-date-begin-1">
                            <span class="input-group-addon">
                        <span class="glyphicon glyphicon-calendar"></span>
                    </span>
                        </div>
                    </div>
                </div>
                <div class="col-xs-6 col-sm-3 col-md-3">
                    <div class="form-group">
                        <label class="control-label">Дата конца</label>
                        <div class="input-group datetimepicker">
                            <input type="datetime" class="form-control" placeholder="" name="photographer-data-end-1">
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
                                    <button type="button" class="btn btn-danger btnRemove-photographer">Удалить</button>
                                </div>
                                <!--
                                                        <label class="control-label">Паспорт</label>
                                                        <input type="text"
                                                               class="form-control"
                                                               placeholder="Серия"
                                                               minlength="4"
                                                               maxlength="4"
                                                               name="photographer-passport-serial-1"
                                                        >
                                -->
                            </div>
                        </div>
                        <div class="col-xs-6 col-sm-7">
                            <div class="form-group">
                                <!--
                                                        <label class="control-label">Номер</label>
                                                        <input type="text"
                                                               class="form-control"
                                                               placeholder="Номер"
                                                               name="photographer-passport-number-1"
                                                        >
                                -->
                            </div>
                        </div>
                    </div>
                    <!--    /паспорт -->
                </div>

            </div>
    <!--    /фотограф    -->
    @endif
    </div>

        <div class="row">
            <div class="col-xs-6 col-sm-4 col-md-3">
                <br>
                <button type="button" class="btn btn-light" id="btnAdd-photographer">
                    Добавить фотографа
                </button>
            </div>
        </div>

    </div>

    <div class="row">
        <div class="col-xs-11 text-right total-page">
            <strong>Итого:</strong> @{{ photo_abs_price }} руб.
        </div>
    </div>

</div>
<!--    /Фотосъемка  -->
</div>
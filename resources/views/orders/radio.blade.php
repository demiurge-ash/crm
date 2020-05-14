<div class="tab-content">

@include('templates.radio-calendar')

<!--    Радио  -->
<div id="radio" class="fade in active">
    <div class="row margin-bottom">
        <div class="col-xs-6 col-sm-6 col-md-3">
            <div class="form-group">
                <label class="control-label">Дата начала</label>
                <div class="input-group datetimepicker">
                    <input type="datetime"
                           class="form-control date-now"
                           name="radio-date-begin"
                           id="radio-date-begin">
                    <span class="input-group-addon">
                        <span class="glyphicon glyphicon-calendar"></span>
                    </span>
                </div>
            </div>
        </div>
        <div class="col-xs-6 col-sm-6 col-md-3">
            <div class="form-group">
                <label class="control-label">Дата конца</label>
                <div class="input-group datetimepicker">
                    <input type="datetime"
                           class="form-control"
                           name="radio-date-end"
                           id="radio-date-end">
                    <span class="input-group-addon">
                        <span class="glyphicon glyphicon-calendar"></span>
                    </span>
                </div>
            </div>
        </div>
        <div class="col-xs-6 col-sm-6 col-md-3">
            <div class="form-group">
                <label class="control-label" for="radioquantity">Количество дней</label>
                <input type="number"
                       class="form-control"
                       id="radioquantity"
                       name="radio-quantity"
                       v-restrict.number
                       value="0"
                >
            </div>
        </div>
        <div class="col-xs-6 col-sm-6 col-md-2">
            <div class="form-group">
                <label class="control-label" for="duration">Длительность ролика</label>
                <input type="number"
                       class="form-control"
                       id="duration"
                       name="radio-duration"
                       v-restrict.number
                       value="0"
                >
            </div>
        </div>
    </div>

    <div class="row">
        <!--    правая часть  -->
        <div class="col-sm-12 col-md-7 margin-bottom">
            <div class="row">
                <div class="col-xs-6 col-sm-6 col-md-3">
                    <div class="form-group">
                        <label class="control-label" for="radioprice">Цена, руб.</label>
                        <input type="number"
                               step="0.01"
                               class="form-control"
                               id="radioprice"
                               name="radio-price"
                               v-model.number="radio_price"
                               v-restrict.number.decimal
                        >
                    </div>
                </div>

                <div class="col-xs-6 col-sm-6 col-md-3">
                    <div class="form-group">
<!-- deprecated
                        <label class="control-label" for="radiocost">Стоимость, руб.</label>
                        <input type="number"
                               class="form-control"
                               id="radiocost"
                               name="radio-cost"
                               v-model="radio_cost"
                               readonly
                        >
-->
                    </div>
                </div>

            </div>
        </div>

        <!--    /правая часть  -->

        <!--    левая часть  -->
        <div class="col-sm-12 col-md-4 margin-bottom">
            <div class="row">
                <div class="col-xs-6">
                    <div class="form-group">
                        <label class="control-label" for="placementsale">Скидка, %</label>
                        <input type="number"
                               step="0.01"
                               class="form-control"
                               id="placementsale"
                               name="radio-sale"
                               v-model.number="radio_sale"
                               v-restrict.number.decimal
                        >
                    </div>
                </div>

                <div class="col-xs-6">
                    <div class="form-group">
                        <label class="control-label"
                               for="placementtotalprice">Итого</label>
                        <input type="number"
                               step="0.01"
                               class="form-control"
                               id="placementtotalprice"
                               name="radio-total-price"
                               v-model="radio_total_price"
                               readonly
                        >
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-xs-6">
                    <label class="radio-inline">
                        <input type="radio"
                               name="radio-placement-paid"
                               value="1"
                               class="input-group-lg"
                               >
                        Оплачено
                    </label>
                </div>
                <div class="col-xs-6">
                    <label class="radio-inline">
                        <input type="radio"
                               name="radio-placement-paid"
                               value="0"
                               checked>
                        Не оплачено
                    </label>
                </div>
            </div>

        </div>
        <!--    /левая часть  -->
    </div>

    <div class="row">
        <div class="form-group col-xs-11">
            <label for="radiotext">Текст</label>
            <textarea rows="3"
                      class="form-control"
                      id="radiotext"
                      placeholder="вводный текст..."
                      name="radio-text">
            </textarea>
        </div>
    </div>
    <div class="row margin-bottom">
        <div class="col-xs-offset-6 col-xs-6 col-sm-offset-8 col-sm-4 col-md-offset-8 col-md-3">
            <button type="button" class="btn btn-light" onclick="printTextAreaRadio()">
                Печатать форму Т3
            </button>
        </div>
    </div>

    <div class="row   margin-bottom">
        <div class="col-xs-12 col-sm-6 col-md-3">
            <div class="form-group">
                <label class="control-label" for="video">Прикрепить готовый ролик (MP3)</label>
                <input type="file" id="video" name="radio-file" accept=".mp3">
            </div>
        </div>
    </div>

    @if( ! empty($current->file))
        <div class="row margin-bottom">
            <div class="col-xs-12 col-sm-6 col-md-3">
                <div class="form-group">
                    <div id="fileUploaded">
                        <label class="control-label">Загруженный файл</label><br>
                        {!! $current->file_link !!}
                    </div>
                </div>
            </div>
        </div>
    @endif

    <div class="row">
        <div class="col-xs-11 text-right total-page">
            <strong>Итого:</strong> @{{ radio_abs_price }} руб.
        </div>
    </div>

</div>
<!--    /Радио  -->
</div>

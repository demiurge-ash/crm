<!--    Дизайн  -->
<div class="row margin-bottom">
    <div class="col-xs-12">
        <!--data-target="#design"-->
        <div class="icon-section">
        <a href="#design{{ $type }}" data-toggle="collapse" class="icon-plus" aria-expanded="false" id="link-visual-design">
            <svg class="collapse__button">
                <circle cx="9.5" cy="9.5" r="9"></circle>
                <path class="collapse__button-line" d="M9.5,5.5 L9.5,13.5"></path>
                <path class="collapse__button-line collapse__button-line--horizontal" d="M5.5,9.5 L13.5,9.5"></path>
            </svg>
            Дизайн
        </a>
        </div>

        <div id="design{{ $type }}" class="collapse collapse_show">

            <div class="row">
                <!--    размер  -->
                <div class="col-sm-12 col-md-7 margin-bottom">
                    <div class="row">

                        <div class="col-xs-3 col-md-3">
                            <div class="form-group">
                                <label class="control-label" for="width">Ширина, мм</label>
                                <input type="number"
                                       class="form-control"
                                       id="visual_width"
                                       name="visual-design-width"
                                       v-model="visual_width"
                                       v-restrict.number
                                >
                            </div>
                        </div>
                        <div class="col-xs-1 text-center">
                            <span class="text">
                                х
                            </span>
                        </div>

                        <div class="col-xs-3 col-md-3">
                            <div class="form-group">
                                <label class="control-label" for="height">Высота, мм</label>
                                <input type="number"
                                       class="form-control"
                                       id="visual_height"
                                       name="visual-design-height"
                                       v-model="visual_height"
                                       v-restrict.number
                                >
                            </div>
                        </div>

                        <div class="col-md-4">
                                    <span class="text-form">
                                        Площадь: @{{ visual_area_total }}.
                                    </span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-4 col-sm-3 col-md-3">
                            <label class="radio-inline">
                                <input v-model="visual_design_side" type="radio" name="visual-design-side" value="0" class="input-group-lg" checked>
                                Односторонний
                            </label>
                        </div>
                        <div class="col-xs-4 col-sm-3 col-md-3">
                            <label class="radio-inline">
                                <input v-model="visual_design_direction" type="radio" name="visual-design-direction" value="0">
                                Вертикальный
                            </label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-4 col-sm-3 col-md-3">
                            <label class="radio-inline">
                                <input v-model="visual_design_side" type="radio" name="visual-design-side" value="1" class="input-group-lg">
                                Двусторонний
                            </label>
                        </div>
                        <div class="col-xs-4 col-sm-3 col-md-3">
                            <label class="radio-inline">
                                <input v-model="visual_design_direction" type="radio" name="visual-design-direction" value="1">
                                Горизонтальный
                            </label>
                        </div>
                    </div>
                </div>
                <!--    /размер  -->

                <!--    оплата  -->
                <div class="col-sm-12 col-md-4 margin-bottom">
                    <div class="row">
                        <div class="col-xs-6">
                            <div class="form-group">
                                <label class="control-label" for="designdate">Дата оплаты</label>
                                <div class="input-group datetimepicker" id="designdate">
                                    <input type="datetime"
                                           class="form-control date-now-paid"
                                           name="visual-design-date-payment"
                                           id="visual-design-date-payment"
                                           readonly
                                    >
                                    <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-calendar cursor-disabled"></span>
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div class="col-xs-6">
                            <div class="form-group">
                                <label class="control-label" for="price">Стоимость</label>
                                <input type="number"
                                       step="0.01"
                                       class="form-control"
                                       id="price"
                                       name="visual-design-total-price"
                                       v-model="visual_design_total_price"
                                       v-restrict.number.decimal
                                >
                            </div>
                        </div>
                    </div>

                    <div class="row">

                        <div class="col-xs-6">
                            <label class="radio-inline">
                                <input type="radio"
                                       name="visual-design-paid"
                                       value="1"
                                       class="input-group-lg"
                                       @click="setDateNow('#visual-design-date-payment')"
                                >
                                Оплачено
                            </label>
                        </div>
                        <div class="col-xs-6">
                            <label class="radio-inline">
                                <input type="radio"
                                       name="visual-design-paid"
                                       value="0"
                                       checked
                                       @click="clearField('#visual-design-date-payment')"
                                >
                                Не оплачено
                            </label>
                        </div>
                    </div>


                </div>
                <!--    /оплата  -->
            </div>

            <!--    загрузка макета -->
            <div class="row   margin-bottom">
                <div class="col-xs-12 col-sm-6 col-md-3">
                    <div class="form-group">
                        <label class="control-label" for="file">Загрузка файла</label>
                        <input type="file" id="file" name="visual-design-file" accept=".pdf,.ai,.psd,.jpg,.jpeg">
                    </div>

                </div>

                <div class="col-xs-3">
                    <label class="checkbox-inline checkbox-inline_file">
                        <input type="checkbox" name="visual-design-confirmed" value="1">
                        Подтвержден
                    </label>
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

            @if( ! empty($current->designer_file))
            <div class="row margin-bottom">
                <div class="col-xs-12 col-sm-6 col-md-3">
                    <div class="form-group">
                        <div id="fileUploaded">
                            <label class="control-label">Готовый макет</label><br>
                            {!! $current->designer_file_link !!}
                        </div>
                    </div>
                </div>
            </div>
            @endif
            <!--    /загрузка макета -->


            <div class="row">
                <div class="form-group col-xs-11">
                    <label for="task">Техническое задание</label>
                    <textarea rows="3"
                              class="form-control"
                              id="task"
                              placeholder="вводный текст..."
                              name="visual-design-task">
                    </textarea>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-offset-6 col-xs-6 col-sm-offset-7 col-sm-4 col-md-offset-8 col-md-3">
                    <button type="button" class="btn btn-light" onclick="printTextArea()">
                        Печатать форму Т3
                    </button>
                </div>
            </div>

            <div class="row">
                <div class="form-group col-xs-11">
                    <label for="task">Правки</label>
                    <textarea rows="3"
                              class="form-control"
                              id="edits"
                              placeholder="..."
                              name="visual-design-edits">
                    </textarea>
                </div>
            </div>

        </div>
    </div>

</div>
<!--    /Дизайн  -->

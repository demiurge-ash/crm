
<!--    Производство  -->
<div class="row margin-bottom">
    <div class="col-xs-12">
        <div class="icon-section">
        <a href="#production" data-toggle="collapse" class="icon-plus" aria-expanded="false" id="link-visual-production">
            <svg class="collapse__button">
                <circle cx="9.5" cy="9.5" r="9"></circle>
                <path class="collapse__button-line" d="M9.5,5.5 L9.5,13.5"></path>
                <path class="collapse__button-line collapse__button-line--horizontal" d="M5.5,9.5 L13.5,9.5"></path>
            </svg>
            Производство
        </a>
        </div>
        <!--    -->
        <div id="production" class="collapse collapse_show">

            <div class="row  margin-bottom">
                <div class="col-xs-4">
                    <div class="form-group">
                        <label class="control-label" for="visual-production-duplicate">Вид продукции</label>
                        <input type="text"
                               name="visual-production-duplicate"
                               class="form-control production-duplicate"
                               readonly
                        >
                    </div>
                </div>
            </div>

            <div class="row  margin-bottom">
                <div class="col-xs-4">
                    <div class="form-group">
                        <label class="control-label" for="contractor">Подрядчик</label>

                        @if( ! empty($contractors) && count($contractors))
                        <select class="form-control"
                                id="contractor"
                                name="visual-production-contractor"
                                v-model="visual_production_contractor"
                        >
                            <option value="0">—</option>
                            @foreach($contractors as $item)
                            <option value="{{ $item->id }}">{{ $item->name }}</option>
                            @endforeach
                        </select>
                        @endif

                    </div>
                </div>
            </div>

            <div class="row">
                <!--    размер  -->
                <div class="col-sm-12 col-md-8 margin-bottom">
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

                        <div class="col-md-5">
                            <span class="text-form">
                                Площадь: @{{ visual_area_total }}.
                            </span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-4 col-sm-3 col-md-3">
                            <label class="radio-inline">
                                <input v-model="visual_design_side" type="radio" name="visual-production-side" value="0" class="input-group-lg" checked>
                                Односторонний
                            </label>
                        </div>
                        <div class="col-xs-4 col-sm-3 col-md-3">
                            <label class="radio-inline">
                                <input v-model="visual_design_direction" type="radio" name="visual-production-direction" value="0">
                                Вертикальный
                            </label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-4 col-sm-3 col-md-3">
                            <label class="radio-inline">
                                <input v-model="visual_design_side" type="radio" name="visual-production-side" value="1" class="input-group-lg">
                                Двусторонний
                            </label>
                        </div>
                        <div class="col-xs-4 col-sm-3 col-md-3">
                            <label class="radio-inline">
                                <input v-model="visual_design_direction" type="radio" name="visual-production-direction" value="1">
                                Горизонтальный
                            </label>
                        </div>
                    </div>
                </div>
                <!--    /размер  -->
            </div>


            <div class="row">
                <!--    правая часть  -->
                <div class="col-sm-12 col-md-8 margin-bottom">
                    <div class="row">

                        <div class="col-xs-4 col-sm-4 col-md-3">
                            <div class="form-group">
                                <label class="control-label" for="quantity">Количество</label>
                                <input type="number"
                                       class="form-control"
                                       id="quantity"
                                       name="visual-production-quantity"
                                       v-model="visual_production_quantity"
                                       v-restrict.number
                                >
                            </div>
                        </div>

                        <div class="col-xs-4 col-sm-4 col-md-3">
                            <div class="form-group">
                                <label class="control-label" for="productionprice">Цена, руб.</label>
                                <input type="number"
                                       step="0.01"
                                       class="form-control"
                                       id="productionprice"
                                       name="visual-production-price"
                                       v-model="visual_production_price"
                                       v-restrict.number.decimal
                                >
                            </div>
                        </div>

                        <div class="col-xs-4 col-sm-4 col-md-3">
                            <div class="form-group">
                                <label class="control-label" for="productionprice">Цена подрядчика</label>
                                <input type="number"
                                       step="0.01"
                                       class="form-control"
                                       id="production_contractor_price"
                                       name="visual-production-contractor-price"
                                       value="0"
                                       v-restrict.number.decimal
                                >
                            </div>
                        </div>

                        <div class="col-xs-4 col-sm-4 col-md-3">
                            <div class="form-group">
                                <label class="control-label" for="productioncost">Стоимость, руб.</label>
                                <input type="number"
                                       class="form-control"
                                       id="productioncost"
                                       name="visual-production-cost"
                                       v-model="visual_production_cost"
                                       readonly>
                            </div>
                        </div>

                    </div>
                </div>
                <!--    /правая часть  -->

                <!--    левая часть  -->
                <div class="col-sm-12 col-md-4 margin-bottom">
                    <div class="row">
                        <div class="col-xs-5">
                            <div class="form-group">
                                <label class="control-label" for="sale">Скидка, %</label>
                                <input type="number"
                                       step="0.01"
                                       class="form-control"
                                       id="sale"
                                       name="visual-production-sale"
                                       v-model="visual_production_sale"
                                       v-restrict.number.decimal
                                >
                            </div>
                        </div>

                        <div class="col-xs-6">
                            <div class="form-group">
                                <label class="control-label" for="totalprice">Итого</label>
                                <input type="number"
                                       class="form-control"
                                       id="totalprice"
                                       name="visual-production-total-price"
                                       v-model="visual_production_total_price"
                                       readonly>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-xs-5">
                            <label class="radio-inline">
                                <input type="radio"
                                       name="visual-production-paid"
                                       value="1"
                                       class="input-group-lg"
                                       checked>
                                Оплачено
                            </label>
                        </div>
                        <div class="col-xs-6">
                            <label class="radio-inline">
                                <input type="radio"
                                       name="visual-production-paid"
                                       value="0">
                                Не оплачено
                            </label>
                        </div>
                    </div>

                </div>
                <!--    /левая часть  -->
            </div>

            <div class="row">
                <div class="form-group col-xs-11">
                    <label for="materials">Материалы и исполнение</label>
                    <textarea rows="3"
                              class="form-control"
                              id="materials"
                              placeholder="вводный текст..."
                              name="visual-production-materials">
                    </textarea>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-offset-6 col-xs-6 col-sm-offset-8 col-sm-4 col-md-offset-8 col-md-3">
                    <button id="copy-materials" type="button" class="btn btn-light">
                        Копировать все
                    </button>
                </div>
            </div>

            <div class="row margin-bottom">
                <div class=" col-xs-12">
                    <label class="checkbox-inline checkbox-inline_file">
                        <input type="checkbox" name="visual-production-confirmed" value="1">
                        Выполнен
                    </label>
                </div>
            </div>

        </div>
    </div>
</div>
<!--    /Производство  -->

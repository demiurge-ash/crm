
<!--    Размещение  -->
<div class="row margin-bottom">
    <div class="col-xs-12">
        <div class="icon-section">
        <a href="#placement" data-toggle="collapse" class="icon-plus" aria-expanded="false" id="link-visual-placement">
            <svg class="collapse__button">
                <circle cx="9.5" cy="9.5" r="9"></circle>
                <path class="collapse__button-line" d="M9.5,5.5 L9.5,13.5"></path>
                <path class="collapse__button-line collapse__button-line--horizontal" d="M5.5,9.5 L13.5,9.5"></path>
            </svg>
            Размещение
        </a>
        </div>
        <!--    -->
        <div id="placement" class="collapse collapse_show">
{{--
            <div class="row margin-bottom">
                <div class="col-xs-12  col-sm-4 col-md-3">
                    <div class="form-group">
                        <!--  объект рекламы и информации -->
                        <label class="control-label" for="ori">ОРИ</label>
                        <input type="text"
                               class="form-control"
                               id="ori"
                               name="visual-placement-ori"
                        >
                    </div>
                </div>
            </div>
--}}

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

            <placement></placement>


            <script type="text/x-template" id="placement-template">

                <div clas="row">
                    <div v-for="(input, index) in visual_placement" :key="input.count">

                        <label class="row col-xs-12 margin-bottom">Поверхность №@{{ input.count }}</label>
                        <input type="hidden" :name="input.surface_number" value="1">

                        <div class="row margin-bottom">
                            <div class="col-xs-6 col-sm-4 col-md-2">
                                <div class="form-group">
                                    <label class="control-label">Дата начала</label>
                                    <div class="form-group">
                                        <input type="date"
                                               class="form-control"
                                               :name="input.visual_placement_date_begin"
                                               :id="input.visual_placement_date_begin"
                                               v-model="input.date_begin"
                                        >
{{--                                        <span class="input-group-addon">
                                            <span class="glyphicon glyphicon-calendar"></span>
                                        </span>--}}
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-6 col-sm-4 col-md-2">
                                <div class="form-group">
                                    <label class="control-label">Дата конца</label>
                                    <div class="form-group">
                                        <input type="date"
                                               class="form-control"
                                               :name="input.visual_placement_date_end"
                                               :id="input.visual_placement_date_end"
                                               v-model="input.date_end"
                                        >
{{--                                        <span class="input-group-addon">
                                            <span class="glyphicon glyphicon-calendar"></span>
                                        </span>--}}
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-4 col-md-3">
                                <div class="form-group">
                                    <label class="control-label">Артикул рекламного места</label>

                                    @if( ! empty($advs) && count($advs))
                                        <select class="form-control"
                                                :name="input.visual_placement_vendor"
                                                :id="input.visual_placement_vendor"
                                                v-model="input.adv_place"
                                                @change="vendor(index)"
                                                data-toggle="test"
                                                data-trigger="hover"
                                                data-placement="top"
                                        >
                                            <option value="" data-location="">—</option>
                                            @foreach($advs as $item)
                                                <option value="{{ $item->id }}" data-location="{{ $item->location }}">{{ $item->place }}</option>
                                            @endforeach
                                        </select>
                                    @endif

                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-4 col-md-4">
                                <div class="form-group">
                                    <label class="control-label">Место расположения</label>
                                    <input class="form-control"
                                           type="text"
                                            :id="input.visual_placement_location"
                                            :name="input.visual_placement_location"
                                           v-model="input.location"
                                    >
                                </div>
                            </div>
                        </div>

                        <div class="row" id="placement">
                            <div class="col-sm-12 col-md-7 margin-bottom">
                                <div class="row">

                                    <div class="col-xs-4 col-sm-4 col-md-3">
                                        <div class="form-group">
                                            <label class="control-label">Количество</label>
                                            <input type="number"
                                                   class="form-control"
                                                   :name="input.visual_placement_quantity"
                                                   :id="input.visual_placement_quantity"
                                                   v-model="input.quantity"
                                                   @input="cost(index)"
                                                   v-restrict.number
                                            >
                                        </div>
                                    </div>

                                    <div class="col-xs-4 col-sm-4 col-md-3">
                                        <div class="form-group">
                                            <label class="control-label">Цена, руб.</label>
                                            <input type="number"
                                                   step="0.01"
                                                   class="form-control"
                                                   :name="input.visual_placement_price"
                                                   :id="input.visual_placement_price"
                                                   v-model="input.price"
                                                   @input="cost(index)"
                                                   v-restrict.number.decimal
                                            >
                                        </div>
                                    </div>

                                    <div class="col-xs-4 col-sm-4 col-md-3">
                                        <div class="form-group">
                                            <label class="control-label">Стоимость, руб.</label>
                                            <input type="number"
                                                   class="form-control"
                                                   :name="input.visual_placement_cost"
                                                   :id="input.visual_placement_cost"
                                                   v-model="input.cost"
                                                   readonly
                                            >
                                        </div>
                                    </div>

                                </div>
                            </div>

                            <div class="col-sm-12 col-md-4 margin-bottom">
                                <div class="row">
                                    <div class="col-xs-6">
                                        <div class="form-group">
                                            <label class="control-label">Скидка, %</label>
                                            <input type="number"
                                                   step="0.01"
                                                   class="form-control"
                                                   :name="input.visual_placement_sale"
                                                   :id="input.visual_placement_sale"
                                                   v-model="input.sale"
                                                   @input="cost(index)"
                                                   v-restrict.number.decimal
                                            >
                                        </div>
                                    </div>

                                    <div class="col-xs-6">
                                        <div class="form-group">
                                            <label class="control-label">Итого</label>
                                            <input type="number"
                                                   class="form-control"
                                                   :name="input.visual_placement_total_price"
                                                   :id="input.visual_placement_total_price"
                                                   v-model="input.total_price"
                                                   readonly
                                            >
                                        </div>
                                    </div>
                                </div>

                                <div class="row">

                                    <div class="col-xs-6">
                                        <label class="radio-inline">
                                            <input type="radio"
                                                   :name="input.visual_placement_paid"
                                                   :id="input.visual_placement_paid"
                                                   v-model="input.paid"
                                                   value="1"
                                                   class="input-group-lg"
                                                   checked>
                                            Оплачено
                                        </label>
                                    </div>
                                    <div class="col-xs-6">
                                        <label class="radio-inline">
                                            <input type="radio"
                                                   :name="input.visual_placement_paid"
                                                   :id="input.visual_placement_paid"
                                                   v-model="input.paid"
                                                   value="0"
                                            >
                                            Не оплачено
                                        </label>
                                    </div>
                                </div>

                            </div>
                        </div>

                    </div>

                    <div class="row">
                        <div class="col-xs-6 col-sm-4 col-md-3">
                            <button type="button" class="btn btn-light" @click="addRow" id="add-placement">
                                Добавить поверхность
                            </button>
                        </div>
                    </div>
                </div>
            </script>

            <div class="row margin-bottom">
                <div class=" col-xs-12">
                    <label class="checkbox-inline checkbox-inline_file">
                        <input type="checkbox" name="visual-placement-confirmed" value="1">
                        Выполнен
                    </label>
                </div>
            </div>

        </div>
    </div>
</div>
<!--    /Размещение  -->

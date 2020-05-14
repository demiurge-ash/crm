<!--    Монтаж  -->
<div class="row">
    <div class="col-xs-12">
        <div class="icon-section">
        <a href="#montage{{ $type }}" data-toggle="collapse" class="icon-plus" aria-expanded="false" id="link-visual-montage">
            <svg class="collapse__button">
                <circle cx="9.5" cy="9.5" r="9"></circle>
                <path class="collapse__button-line" d="M9.5,5.5 L9.5,13.5"></path>
                <path class="collapse__button-line collapse__button-line--horizontal" d="M5.5,9.5 L13.5,9.5"></path>
            </svg>
            Монтаж
        </a>
        </div>

    <div id="montage{{ $type }}" class="collapse collapse_show">

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

        <montage></montage>

    <script type="text/x-template" id="montage-template">
        <div clas="row">
        <div v-for="(input, index) in visual_montage" :key="input.count">

        <label class="row col-xs-12 margin-bottom">Поверхность №@{{ input.count }}</label>
        <input type="hidden" :name="input.surface_number" value="1">

            <div class="row margin-bottom">
                <div class="col-xs-12 col-sm-6 col-md-4">
                    <div class="form-group">
                        <label class="control-label">Монтаж/Демонтаж</label>
                        <select class="form-control"
                                name="visual-montage-type"
                                :name="input.visual_montage_type"
                                :id="input.visual_montage_type"
                                v-model="input.montage_type">
                            <option value="0">Монтаж</option>
                            <option value="1">Демонтаж</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="row margin-bottom">
                <div class="col-xs-6 col-sm-6 col-md-2">
                    <div class="form-group">
                        <label class="control-label">Дата начала</label>
                        <div class="form-group">
                            <input type="date"
                                   class="form-control"
                                   :name="input.visual_montage_date_begin"
                                   :id="input.visual_montage_date_begin"
                                   v-model="input.date_begin">
{{--                                <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-calendar"></span>
                                </span>--}}
                        </div>
                    </div>
                </div>
                <div class="col-xs-6 col-sm-6 col-md-2">
                    <div class="form-group">
                        <label class="control-label">Дата конца</label>
                        <div class="form-group">
                            <input type="date"
                                   class="form-control"
                                   :name="input.visual_montage_date_end"
                                   :id="input.visual_montage_date_end"
                                   v-model="input.date_end">
{{--                                <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-calendar"></span>
                                </span>--}}
                        </div>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-6 col-md-3">
                    <div class="form-group">
                        <label class="control-label">Артикул рекламного места</label>
                        <input type="text"
                               class="form-control"
                               :name="input.visual_montage_name"
                               :id="input.visual_montage_name"
                               v-model="input.name">
                    </div>
                </div>
                <div class="col-xs-12 col-sm-6 col-md-4">
                    <div class="form-group">
                        <label class="control-label">Место монтажа/демонтажа</label>
                        <input type="text"
                               class="form-control"
                               :name="input.visual_montage_place"
                               :id="input.visual_montage_place"
                               v-model="input.place">
                    </div>
                </div>
            </div>

            <div class="row   margin-bottom">
                <!--    правая часть  -->
                <div class="col-sm-12 col-md-7">
                    <div class="row">

                        <div class="col-xs-6 col-sm-6 col-md-3">
                            <div class="form-group">
                                <label class="control-label">Количество</label>
                                <input type="number"
                                       class="form-control"
                                       :name="input.visual_montage_quantity"
                                       :id="input.visual_montage_quantity"
                                       v-model="input.quantity"
                                       @input="cost(index)"
                                       v-restrict.number
                                >
                            </div>
                        </div>

                        <div class="col-xs-6 col-sm-6 col-md-3">
                            <div class="form-group">
                                <label class="control-label">Цена, руб.</label>
                                <input type="number"
                                       step="0.01"
                                       class="form-control"
                                       :name="input.visual_montage_price"
                                       :id="input.visual_montage_price"
                                       v-model="input.price"
                                       @input="cost(index)"
                                       v-restrict.number.decimal
                                >
                            </div>
                        </div>

                    </div>
                </div>
                <!--    /правая часть  -->

                <!--    левая часть  -->
                <div class="col-sm-12 col-md-4">
                    <div class="row">
                        <div class="col-xs-6">
                            <div class="form-group">
                                <label class="control-label">Скидка, %</label>
                                <input type="number"
                                       step="0.01"
                                       class="form-control"
                                       :name="input.visual_montage_sale"
                                       :id="input.visual_montage_sale"
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
                                       :name="input.visual_montage_total_price"
                                       :id="input.visual_montage_total_price"
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
                                       :name="input.visual_montage_paid"
                                       :id="input.visual_montage_paid"
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
                                       :name="input.visual_montage_paid"
                                       :id="input.visual_montage_paid"
                                       v-model="input.paid"
                                       value="0"
                                >
                                Не оплачено
                            </label>
                        </div>
                    </div>

                </div>
                <!--    /левая часть  -->
            </div>
            <div class="row   margin-bottom">
                <div class="col-xs-12 col-sm-6 col-md-4">
                    <div class="form-group">
                        <label class="control-label">Менеджер</label>

                        @if( ! empty($managers) && count($managers))
                        <select class="form-control"
                                :name="input.visual_montage_manager"
                                :id="input.visual_montage_manager"
                                v-model="input.manager"
                        >
                            @foreach($managers as $item)
                            <option value="{{ $item->id }}">{{ $item->name }}</option>
                            @endforeach
                        </select>
                        @endif

                    </div>
                </div>

                <div class="col-xs-12 col-sm-6">
                    <label class="checkbox-inline checkbox-inline_file">
                        <input type="checkbox"
                               :name="input.visual_montage_confirmed"
                               :id="input.visual_montage_confirmed"
                               v-model="input.confirmed"
                               value="1">
                        Работы выполнена
                    </label>
                </div>
            </div>

    </div>

    <div class="row">
        <div class="col-xs-6 col-sm-4 col-md-3">
            <button type="button" class="btn btn-light" @click="addRow" id="add-montage">
                Добавить поверхность
            </button>
        </div>
    </div>

    </div>
    </script>

        </div>
    </div>
</div>
<!--    /Монтаж  -->

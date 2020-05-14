<div class="row">

    <div class="col-md-2">
        <div class="form-group">
            <label class="checkbox-inline checkbox-inline_file" for="visual-bypass">
            <input type="checkbox"
                   id="visual-bypass"
                   name="visual-bypass"
                   value="1">
                Обходной
            </label>
        </div>
    </div>

    <div class="col-md-2">
        <div class="form-group" id="visual-bypass-type-block" style="display: none">
            <label class="control-label" for="visual-bypass-type">Виды обходного</label>
                <select class="form-control"
                        id="visual-bypass-type"
                        name="visual_bypass_type"
                        v-model="visual_bypass_type">
                    <option value="order">—</option>
                    <option value="entry">Обходной. Въезд.</option>
                    <option value="departure">Обходной. Выезд.</option>
                    <option value="replacement">Обходной. Замена.</option>
                </select>
        </div>
    </div>

    <div class="col-md-8">
        <div class="form-group" id="visual-bypass-categories-block" style="display: none">

        @if( ! empty($goodCategories) && count($goodCategories))
                <div class="col-md-4">
                    <div class="form-group">
                        <label class="control-label" for="view">Категория товара ДО</label>
                        <select class="form-control"
                                id="view"
                                name="replacement-category-before"
                        >
                            @include('orders.goods-category')
                        </select>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group">
                        <label class="control-label" for="view">Категория товара ПОСЛЕ</label>
                        <select class="form-control"
                                id="view"
                                name="replacement-category-after"
                        >
                            @include('orders.goods-category')
                        </select>
                    </div>
                </div>
            @endif

        </div>
    </div>
</div>


<div class="row"  id="visual-pavilion-block" style="display: none">

    <div class="col">
        <div class="form-group">

            @if( ! empty($pavilions) && count($pavilions))
                <div class="col-md-4">
                    <div class="form-group">
                        <label class="control-label" for="visual_pavilion_before">Из павильона</label>
                        <select class="form-control"
                                id="visual_pavilion_before"
                                name="visual_pavilion_before"
                                v-model="visual_pavilion_before">
                            <option value="0">—</option>
                            @foreach($pavilions as $item)
                                <option value="{{ $item->id }}">
                                    {{ $item->pavilion }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group">
                        <label class="control-label" for="visual_pavilion_after">В павильон</label>
                        <select class="form-control"
                                id="visual_pavilion_after"
                                name="visual_pavilion_after"
                                v-model="visual_pavilion_after">
                            <option value="0">—</option>
                            @foreach($pavilions as $item)
                                <option value="{{ $item->id }}">
                                    {{ $item->pavilion }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
            @endif

        </div>
    </div>

</div>

<hr class="small">
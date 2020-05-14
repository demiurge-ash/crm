<!--    вид продукции ... дизайнер  -->
<div class="row margin-bottom product-original">

    <div class="col-xs-12 col-sm-6 col-md-4">
        <div class="form-group">
            <label class="control-label" for="view">Вид продукции</label>

            @if( ! empty($productions) && count($productions))
                <select class="form-control"
                        id="view"
                        name="visual-product"
                        v-model="visual_product">
                    @foreach($productions as $item)
                        <option id="visual-product-{{ $item->id }}"
                                value="{{ $item->id }}"
                                data-specification="{{ $item->specification }}"
                                data-type="{{ $item->production }}"
                        >{{ $item->production }}</option>
                    @endforeach
                </select>
            @endif

        </div>
    </div>
    @if( empty($designer))
    <div class="col-xs-12 col-sm-6 col-md-4">
        <div class="form-group">
            <label class="control-label" for="designer">Дизайнер</label>

            @if( ! empty($designers) && count($designers))
                <select class="form-control"
                        id="designer"
                        v-model="visual_designer"
                        name="visual-designer">
                    <option value="0">—</option>
                    @foreach($designers as $item)
                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                    @endforeach
                </select>
            @endif

        </div>
    </div>
    @endif

</div>
<!--    /вид продукции ... дизайнер  -->
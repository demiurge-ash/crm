<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">

                <div class="card-header">Загрузка готового макета к заказу №{{ $order->order_id }}</div>
                <div class="card-body">
                @if ($order->designer_file)
                        <div class="alert alert-success" role="alert">
                    Уже загружен. Если вы загрузите еще один файл, то он перезапишет существующий.
                    </div>
                @endif
                <form id="designerform" method="POST" action="/designer/file" class="validateform" autocomplete="off" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="order_id" value="{{ $order->order_id }}">
                    <div class="form-group">
                        <input type="file" class="form-control-file" name="designer_file" id="designer_file"  accept=".pdf,.ai,.psd,.jpg,.jpeg">
                        <br>
                        <button type="submit" class="btn btn-success" id="submit">
                            Сохранить
                        </button>
                    </div>
                </form>

                </div>

            </div>
        </div>
    </div>
</div>
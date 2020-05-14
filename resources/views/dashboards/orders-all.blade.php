<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">

                <div class="card-header">Список заказов</div>
                <div class="card-body">

                    <form method="POST" action="/orders">
                    @csrf
                    <div class="row">
                        <div class="col-sm text-center">
                            <label for="dateBegin" class="sr-only">c даты</label>
                            <input type="date" class="form-control" id="dateBegin" name="dateBegin" value="{{ $dateBegin }}">
                        </div>
                        <div class="col-sm text-center">
                            <label for="dateEnd" class="sr-only">по дату</label>
                            <input type="date" class="form-control" id="dateEnd" name="dateEnd" value="{{ $dateEnd }}">
                        </div>
                        <div class="col-sm text-center">
                            <button type="submit" class="btn btn-success">Показать заказы</button>
                        </div>
                    </div>
                    </form>
                    <br>

                    @include('templates.order-table')

                </div>

            </div>
        </div>
    </div>
</div>
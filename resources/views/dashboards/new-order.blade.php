@if(Auth::user()->isManager())
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">

                <div class="card-header">Панель управления</div>
                <div class="card-body">

                    <div class="col text-center">
                        <a href="{{ route('order') }}">
                            <button type="submit" class="btn btn-success" id="createOrder">
                                Создать новый заказ!
                            </button>
                        </a>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
<br>
@endif
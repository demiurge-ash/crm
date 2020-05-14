<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">

                <div class="card-header">Клиент «<a href="/admin/clients/{{ $client->id }}/edit">{{ $client->name }}</a>»</div>
                <div class="card-body">

                    <h5 class="card-subtitle mb-2 text-muted">Телефон</h5>
                    <li class="list-group-item">{{ $client->phone }}</li>
                    <br>

                    <h5 class="card-subtitle mb-2 text-muted">Email</h5>
                    <li class="list-group-item">{{ $client->email }}</li>
                    <br>

                    <h5 class="card-subtitle mb-2 text-muted">Описание</h5>
                    <li class="list-group-item">{{ $client->description }}</li>
                    <br>

                    <h5 class="card-subtitle mb-2 text-muted">Файлы</h5>
                    <p class="card-text">
                    @forelse($designFiles as $design)

                        <li class="list-group-item">
                        @if( ! empty($design->file))
                            <a href="/storage/{{ $design->file }}">
                                файл заказа «Дизайн» №{{ $design->order_id }}
                            </a>
                        @endif
                        @if( ! empty($design->designer_file))
                            <br>
                            <a href="/storage/{{ $design->designer_file }}">
                                готовый макет «Дизайн» №{{ $design->order_id }}
                            </a>
                        @endif
                        </li>

                    @empty
                    @endforelse

                    @forelse($radioFiles as $radio)

                        <li class="list-group-item">
                            @if( ! empty($radio->file))
                                <a href="/storage/{{ $radio->file }}">
                                    файл заказа «Радио» №{{ $radio->order_id }}
                                </a>
                            @endif
                        </li>

                    @empty
                    @endforelse

                    </p>
                    <br>

                </div>

            </div>
        </div>
    </div>
</div>
<br>

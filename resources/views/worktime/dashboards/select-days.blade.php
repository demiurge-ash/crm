<div class="container">
    <div class="row justify-content-center">
        <div class="col">
            <div class="card">

                <div class="card-header">Выбор дней</div>
                <div class="card-body">

                    <form method="POST" action="/tracking/worktime">
                        @csrf
                        <div class="row justify-content-md-center">

                            <div class="col-2 text-center">
                                <label for="beginDate" class="sr-only">c даты</label>
                                <input type="date"
                                       class="form-control"
                                       id="beginDate"
                                       name="beginDate"
                                       required
                                       value="{{ $beginDate ?? '' }}">
                            </div>

                            <div class="col-2 text-center">
                                <label for="endDate" class="sr-only">по дату</label>
                                <input type="date"
                                       class="form-control"
                                       id="endDate"
                                       name="endDate"
                                       required
                                       value="{{ $endDate ?? '' }}">
                            </div>

                            <div class="col-3">
                                <label class="sr-only" for="user_id">Сотрудник</label>
                                <select class="form-control select2" id="user_id" name="user_id">
                                    <option value=""> — Все сотрудники — </option>
                                    @foreach($users as $user)
                                        <option value="{{ $user->id }}"
                                            @if( ! empty($currentUser))
                                                @if($user->id == $currentUser->id) selected @endif
                                            @endif
                                        >
                                            {{ $user->name ?? '' }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-2 text-left">
                                <button type="submit" class="btn btn-success">Показать</button>
                            </div>

                        </div>
                    </form>

                </div>

            </div>
        </div>
    </div>
</div>
<br>
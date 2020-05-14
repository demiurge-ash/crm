<div class="form-group form-row">
    <div class="col">
        <label class="col-form-label" for="user_id">Сотрудник</label>
        <select class="form-control select2"  id="user_id" name="user_id">
            @foreach($users as $user)
                <option value="{{ $user->id }}"
                        @if( ! empty($current->user_id) && ($current->user_id == $user->id))
                        selected
                        @endif
                >{{ $user->name }}</option>
            @endforeach
        </select>
    </div>
</div>

<div class="form-group form-row">
    <div class="col">
        <label class="col-form-label" for="user">Начало</label>
        <input class="form-control"  name="time_begin" type="time" value="{{ $current->time_begin ?? '' }}">
    </div>
    <div class="col">
        <label class="col-form-label" for="user">Окончание</label>
        <input class="form-control" name="time_end" type="time" value="{{ $current->time_end ?? '' }}">
    </div>
</div>

<div class="form-group form-row">
    <div class="col">
        <label class="col-form-label" for="user">С какого дня применить график</label>
        <input class="form-control"  name="date" type="date" value="{{ $current->date ?? '' }}">
    </div>
</div>
<br>
<div class="form-group form-row">

    <div class="col text-right">
        <button type="submit"
                class="btn btn-success"
                id="storeButton">Сохранить</button>
    </div>
</div>
@extends('voyager::master')

@section('page_title', __('voyager::generic.'.(isset($dataTypeContent->id) ? 'edit' : 'add')).' '.$dataType->getTranslatedAttribute('display_name_singular'))

@section('css')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@stop

@section('page_header')
    <h1 class="page-title">
        <i class="{{ $dataType->icon }}"></i>
        {{ __('voyager::generic.'.(isset($dataTypeContent->id) ? 'edit' : 'add')).' '.$dataType->getTranslatedAttribute('display_name_singular') }}
    </h1>
@stop

@section('content')
    <div class="page-content container-fluid">

        {{-- protect admin --}}
        @if ($dataTypeContent->id == 1  && ! auth()->user()->hasRole('admin'))
            <div class="row">
                <div class="col-md-8">
                    <div class="panel panel-bordered">
                        <div class="alert alert-danger">
                            <ul>
                                <li>Нет доступа к данным</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        @else

        <form class="form-edit-add" role="form"
              action="@if(!is_null($dataTypeContent->getKey())){{ route('voyager.'.$dataType->slug.'.update', $dataTypeContent->getKey()) }}@else{{ route('voyager.'.$dataType->slug.'.store') }}@endif"
              method="POST" enctype="multipart/form-data" autocomplete="off">
            <!-- PUT Method if we are editing -->
            @if(isset($dataTypeContent->id))
                {{ method_field("PUT") }}
            @endif
            {{ csrf_field() }}

            <div class="row">
                <div class="col-md-8">
                    <div class="panel panel-bordered">
                    {{-- <div class="panel"> --}}
                        @if (count($errors) > 0)
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <div class="panel-body">

                            <div class="form-group" >
                                <label for="name">Работает?</label>
                                <br>
                                @php $checked = false; @endphp
                                @if (isset($dataTypeContent->active) || old($dataTypeContent->active))
                                    @php $checked = old('active', $dataTypeContent->active); @endphp
                                @else
                                    @php $checked = isset($options->checked) && $options->checked ? true : false; @endphp
                                @endif

                                <input type="checkbox" name="active" class="toggleswitch"
                                       data-on="Да" {!! $checked ? 'checked="checked"' : '' !!}
                                       data-off="Нет">
                            </div>

                            <div class="form-group">
                                <label for="name">{{ __('voyager::generic.name') }}</label>
                                <input type="text" class="form-control" id="name" name="name" placeholder="{{ __('voyager::generic.name') }}"
                                       value="{{ old('name', $dataTypeContent->name ?? '') }}">
                            </div>

                            <div class="form-group">
                                <label for="email">{{ __('voyager::generic.email') }}</label>
                                <input type="email" class="form-control" id="email" name="email" placeholder="{{ __('voyager::generic.email') }}"
                                       value="{{ old('email', $dataTypeContent->email ?? '') }}">
                            </div>

                            <div class="form-group">
                                <label for="password">{{ __('voyager::generic.password') }}</label>
                                @if(isset($dataTypeContent->password))
                                    <br>
                                    <small>{{ __('voyager::profile.password_hint') }}</small>
                                @endif
                                <input type="password" class="form-control" id="password" name="password" value="" autocomplete="new-password">
                            </div>

                            <div class="form-group">
                                <label for="phone">{{ __('voyager/generic.phone') }}</label>
                                <input type="text" class="form-control" id="phone" name="phone" placeholder=""
                                       value="@if(isset($dataTypeContent->phone)){{ $dataTypeContent->phone }}@endif">
                            </div>

                            <div class="form-group">
                                <label for="description">{{ __('voyager/generic.description') }}</label>
                                <input type="text" class="form-control" id="description" name="description" placeholder=""
                                       value="@if(isset($dataTypeContent->description)){{ $dataTypeContent->description }}@endif">
                            </div>

                            <div class="form-group">
                                <label for="work_time_begin">Время начала работы</label>
                                <input type="time" class="form-control" id="work_time_begin" name="work_time_begin" placeholder=""
                                       value="@if(isset($dataTypeContent->work_time_begin)){{ date('H:i', strtotime($dataTypeContent->work_time_begin)) }}@endif">
                            </div>

                            <div class="form-group">
                                <label for="work_time_end">Время окончания работы</label>
                                <input type="time" class="form-control" id="work_time_end" name="work_time_end" placeholder=""
                                       value="@if(isset($dataTypeContent->work_time_end)){{ date('H:i', strtotime($dataTypeContent->work_time_end)) }}@endif">
                            </div>

                        @can('editRoles', $dataTypeContent)
                                <div class="form-group">
                                    <label for="default_role">Должность</label>
                                    @php
                                        $dataTypeRows = $dataType->{(isset($dataTypeContent->id) ? 'editRows' : 'addRows' )};

                                        $row     = $dataTypeRows->where('field', 'user_belongsto_role_relationship')->first();
                                        $options = $row->details;
                                    @endphp
                                    @include('voyager::formfields.relationship')
                                </div>
                            @endcan

                            <input hidden name="locale" value="ru">

                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="panel panel panel-bordered panel-warning">
                        <div class="panel-body">
                            <div class="form-group">
                                <label>Выберите рабочие дни</label>
                                <div id="my-calendar"></div>
                                <input id="workingDates" name="working_days" hidden>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="panel panel panel-bordered panel-warning">
                        <div class="panel-body">
                            <div class="form-group">
                                @if(isset($dataTypeContent->avatar))
                                    <img src="{{ filter_var($dataTypeContent->avatar, FILTER_VALIDATE_URL) ? $dataTypeContent->avatar : Voyager::image( $dataTypeContent->avatar ) }}" style="width:200px; height:auto; clear:both; display:block; padding:2px; border:1px solid #ddd; margin-bottom:10px;" />
                                @endif
                                <input type="file" data-name="avatar" name="avatar">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <button type="submit" class="btn btn-primary pull-right save" id="submit-button">
                {{ __('voyager::generic.save') }}
            </button>
        </form>

        <iframe id="form_target" name="form_target" style="display:none"></iframe>
        <form id="my_form" action="{{ route('voyager.upload') }}" target="form_target" method="post" enctype="multipart/form-data" style="width:0px;height:0;overflow:hidden">
            {{ csrf_field() }}
            <input name="image" id="upload_file" type="file" onchange="$('#my_form').submit();this.value='';">
            <input type="hidden" name="type_slug" id="type_slug" value="{{ $dataType->slug }}">
        </form>
    </div>

    @endif

@stop

@section('javascript')
    <link href="/css/datepicker.css" rel="stylesheet">
    <script src="/js/datepicker.js"></script>

    <script>
        $('document').ready(function () {
            $('.toggleswitch').bootstrapToggle();

            @if($dataTypeContent->working_days)
                    @php $workingDaysArray = explode(',', $dataTypeContent->working_days)@endphp
                workingDays = [ @foreach($workingDaysArray as $day) new Date('{{ $day }}T21:00:00.000Z'),
                @endforeach ];
            @else  workingDays = [];
            @endif

                myDatepicker = $('#my-calendar').datepicker({
                multipleDates: true,
                timeFormat: null,
                dateFormat: 'yyyy-mm-dd',

            }).data('datepicker');
            myDatepicker.selectDate(workingDays);
            myDatepicker.date = new Date();

            $('#submit-button').hover(function(e){
                newDates = myDatepicker.selectedDates
                newDatesFormated =[];
                newDates.forEach(function(item, i, arr) {
                    preparedDay = item.toISOString().replace("T21:00:00.000Z", "");
                    newDatesFormated.push(preparedDay);
                });
                $('#workingDates').val( newDatesFormated );
                //console.log(newDatesFormated);
                //console.log('tset');
            });

        });
    </script>
@stop

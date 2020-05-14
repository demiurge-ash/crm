@extends('layouts.app')

@section('title')
    Заполнение времени входа-выхода сотрудников
@endsection

@section('content')

    @include('worktime.dashboards.form-week')

@endsection

@extends('layouts.app')

@section('title')
    Заполнения времени входа-выхода сотрудников
@endsection

@section('content')

    @include('worktime.dashboards.select-week')

    @include('worktime.dashboards.upload-file')

@endsection

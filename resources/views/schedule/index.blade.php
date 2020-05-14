@extends('layouts.app')

@section('title')
    Графики рабочего времени
@endsection

@section('content')

    @include('schedule.dashboards.add')

    @include('schedule.dashboards.index')

@endsection

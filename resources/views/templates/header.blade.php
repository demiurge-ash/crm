<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>{{ trim(View::yieldContent('title', 'CRM Москва')) }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, width=1080">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link href="https://fonts.googleapis.com/css?family=Roboto:100,100i,300,300i,400,400i,500,500i,700,700i,900,900i" rel="stylesheet">

    <link href="/css/bootstrap.min.css?20200122" rel="stylesheet">
    <link href="/css/bootstrap-datetimepicker.min.css" rel="stylesheet">
    <link href="/css/style.css" rel="stylesheet">
    <link href="/css/custom.css?2020-02-17" rel="stylesheet">
    <link href="/css/navbar.css" rel="stylesheet">

    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->

    <script src="/js/app.js?2020-01-31"></script>
    <script src="/js/multifield/jquery.multifield.js"></script>
    <script src="/js/custom.js?2019-12-25"></script>
</head>

<body>

    <nav class="navbar navbar-expand-md navbar-light navbar-laravel">
        <div class="nav-container">
            @include('layouts.navbar')
        </div>
    </nav>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title') CRM Москва</title>

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('datatables/datatables.css') }}" rel="stylesheet">
    <link href="{{ asset('css/datepicker.css') }}" rel="stylesheet">
    <link href="{{ asset('css/custom.css') }}" rel="stylesheet">

    <!-- Scripts -->
    <script src="{{ asset('js/app.js?2020-01-31') }}"></script>
    <script src="{{ asset('datatables/datatables.min.js') }}"></script>
    <script src="{{ asset('/js/multifield/jquery.multifield.js') }}"></script>
    <script src="{{ asset('/js/datepicker.js') }}"></script>
    <script src="{{ asset('js/custom.js?2019-12-24') }}"></script>

</head>
<body>
    <div id="app">

        <nav class="navbar navbar-expand-md navbar-light navbar-laravel">
            <div class="container">
                @include('layouts.navbar')
            </div>
        </nav>

        <main class="py-4">

            @if (session('status'))
                <div class="container">
                    <div class="alert alert-success text-center" role="alert" style="color: {{ session('color') ?? '' }}" id="alert-block">
                        {!! session('status') !!}
                    </div>
                </div>
            @endif

            @if ($errors->any())
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-md-8">

                            <div class="alert alert-danger pt-4">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>

                        </div>
                    </div>
                </div>
            @endif

            @yield('content')

            @if (Auth::check())
                @include('chat.index')
            @endif

        </main>
    </div>

    <script>
        $(document).ready( function () {
//            document.addEventListener("DOMContentLoaded", function(event) {

            @yield('script')

            @stack('scripts')

        } );
    </script>

    @yield('footer')


</body>
</html>

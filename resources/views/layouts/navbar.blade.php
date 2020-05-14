<a class="navbar-brand" href="{{ url('/') }}">
    <img class="nav-image" src="/img/logo-optmoskva-crm-small.png" style="max-height: 40px;" alt="ТЯК МОСКВА">
</a>

<div class="collapse navbar-collapse" id="navbarSupportedContent">

    <!-- Left Side Of Navbar -->
    @auth
        <ul class="navbar-nav mr-auto">

            @if(Auth::user()->isManager())
            <li class="nav-item">
                <a class="nav-link" href="/order">Создать заказ</a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="/orders">Заказы</a>
            </li>

            @endif

            @if(Auth::user()->isBoss())
            <li class="nav-item">
                <a class="nav-link" href="/clients">Клиенты</a>
            </li>

            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle"
                   href="#" role="button"
                   data-toggle="dropdown"
                   aria-haspopup="true"
                   aria-expanded="false"
                   v-pre id="menuTime"
                >Учёт времени</a>
                <div class="dropdown-menu" aria-labelledby="menuTime">
                    <a class="dropdown-item" href="/tracking/absent">График отсутствия</a>
                    <a class="dropdown-item" href="/tracking/worktime">Рабочее время</a>
                    <a class="dropdown-item" href="/tracking/worktime/select-week">Заполнение рабочего времени</a>
                    <a class="dropdown-item" href="/tracking/schedule">Графики рабочего времени</a>
                </div>
            </li>
            @endif

        </ul>
    @endauth


    <!-- Right Side Of Navbar -->
    <ul class="navbar-nav ml-auto">
        <!-- Authentication Links -->
        @guest
            <li class="nav-item">
                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
            </li>
        @else
            <li class="nav-item dropdown">
                <a id="navbarDropdown"
                   class="nav-link dropdown-toggle"
                   href="#"
                   role="button"
                   data-toggle="dropdown"
                   aria-haspopup="true"
                   aria-expanded="false"
                   v-pre
                >
                    {{ Auth::user()->name }}
                </a>

                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item" href="{{ route('logout') }}"
                       onclick="event.preventDefault();
                                                 document.getElementById('logout-form').submit();">
                        {{ __('Logout') }}
                    </a>

                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </div>
            </li>
        @endguest
    </ul>
</div>

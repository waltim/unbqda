<div class="topo">

    <div class="logo">
        <img src="{{ asset('img/logo.png') }}">
    </div>
    <div class="menu-2">
        <ul class="nav justify-content-end">

            <li class="nav-item"><a class="nav-link" href="{{ route('project.index') }}">Projetos</a></li>

            @if (Route::has('login'))
                @auth
                    <li class="nav-item"><a class="nav-link" href="{{ url('/home') }}">Home</a></li>
                @endauth
            @endif
            <li class="nav-item">
                <a class="nav-link" href="#">Link</a>
            </li>
            <li class="nav-item dropdown">
                @guest
                @else
                    <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true"
                        aria-expanded="false">{{ Auth::user()->name }}</a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="{{ route('logout') }}"
                            onclick="event.preventDefault();
                                                                                document.getElementById('logout-form').submit();">
                            {{ __('Logout') }}
                        </a>

                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </div>
                @endguest
            </li>
        </ul>
    </div>

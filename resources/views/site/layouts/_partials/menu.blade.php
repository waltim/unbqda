<div class="topo">

    <div class="logo">
        <img src="{{ asset('img/logo.png') }}">
    </div>

    <div class="menu">
        <ul class="nav justify-content-end">
            @if (Route::has('login'))
                @auth
                    <li class="nav-item"><a class="nav-link" href="{{ url('/home') }}">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="">About us</a></li>
                    <li class="nav-item"><a class="nav-link" href="">Contact</a></li>
                @endauth
            @endif
            <!-- Authentication Links -->
            @guest
                @if (Route::has('register'))
                <li class="nav-item"><a class="nav-link" href="{{ url('/') }}">Home</a></li>
                <li class="nav-item"><a class="nav-link" href="">About us</a></li>
                <li class="nav-item"><a class="nav-link" href="">Contact</a></li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                    </li>
                @endif
            @else
            @endguest
        </ul>
    </div>
</div>

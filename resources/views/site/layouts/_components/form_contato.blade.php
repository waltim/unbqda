{{-- <form method="POST" action="{{ route('login') }}">
    @csrf
    <div class="form-group row">
        <label for="email" class="col-md-12 col-form-label text-md-left">Endereço de email</label>

        <div class="col-md-6">
            <input id="email" type="email" class="form-control borda-branca @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

            @error('email')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
    </div>

    <div class="form-group row">
        <label for="password" class="col-md-12 col-form-label text-md-left">Senha</label>

        <div class="col-md-6">
            <input id="password" type="password" class="form-control borda-branca @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

            @error('password')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
    </div>

    <div class="form-group row">
        <div class="col-md-6 offset-md-1">
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                <label class="form-check-label" for="remember">
                    {{ __('Remember Me') }}
                </label>
            </div>
        </div>
    </div>

    <div class="form-group row ">
        <div class="col-md-8 offset-md-4">
            <button type="submit" class="button btn">
                {{ __('Login') }}
            </button>

            @if (Route::has('password.request'))
                <a class="btn btn-link" style="text-decoration: none;" href="{{ route('password.request') }}">
                    {{ __('Forgot Your Password?') }}
                </a>
            @endif
        </div>
    </div>
</form> --}}
<form method="POST" action="{{ route('login') }}">
    @csrf
    <div class="form-row">
        <div class="form-group col-md-6">
            <label for="inputEmail4">Email</label>
            <input id="email" type="email" placeholder="Email"
                class="form-control borda-branca @error('email') is-invalid @enderror" name="email"
                value="{{ old('email') }}" required autocomplete="email" autofocus>
            @error('email')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
        <div class="form-group col-md-6">
            <label for="inputPassword4">Password</label>
            <input id="password" type="password" placeholder="Password"
                class="form-control borda-branca @error('password') is-invalid @enderror" name="password" required
                autocomplete="current-password">
            @error('password')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
    </div>
    <div class="form-group">
        <div class="form-check">
            <input class="form-check-input" type="checkbox" id="gridCheck">
            <label class="form-check-label" for="gridCheck">
                {{ __('Remember Me') }}
            </label>
        </div>
    </div>
    <div class="form-group">
        <div class="form-check">
            @if (Route::has('password.request'))
                <a class="btn btn-outline-warning" href="{{ route('password.request') }}">
                    {{ __('Forgot Your Password?') }}
                </a>
            @endif
        </div>
    </div>
    <button type="submit" class="btn btn-primary">Sign in</button>
</form>

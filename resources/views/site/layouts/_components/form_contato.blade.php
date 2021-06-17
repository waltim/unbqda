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
    {{-- <div class="form-group">
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
    </div> --}}
    <button type="submit" class="btn btn-primary">Sign in</button>
</form>

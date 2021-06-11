@extends('site.layouts.basico')

@section('titulo', 'Login')

@section('conteudo')

    <div class="conteudo-pagina">
        <div class="titulo-pagina">
            <h1>Login</h1>
        </div>

        <div class="informacao-pagina">
            <div style="width: 30%; margin-left: auto; margin-right: auto;">
                <form action="{{ route('site.login') }}" method="POST">
                    @csrf
                    <input name="username" value="{{ old('username') }}" type="text" placeholder="Usúario" class="borda-preta">
                    <br>
                    {{ $errors->has('username') ? $errors->first('username') : '' }}
                    <br>
                    <input name="password" value="{{ old('password') }}" type="text" placeholder="Senha" class="borda-preta">
                    <br>
                    {{ $errors->has('password') ? $errors->first('password') : '' }}
                    <br>
                    <button type="submit" class="borda-preta">Acessar</button>
                </form>
                @isset($erro)
                @if ($erro == 1)
                <h3>Erro de login. Tente novamente.</h3>
                @else
                <h3>É necessário estar logado para acessar essa rota.</h3>
                @endif

                @endisset
            </div>
        </div>
    </div>

    <div class="rodape">
        <div class="redes-sociais">
            <h2>Redes sociais</h2>
            <img src="{{ asset('img/facebook.png') }}">
            <img src="{{ asset('img/linkedin.png') }}">
            <img src="{{ asset('img/youtube.png') }}">
        </div>
        <div class="area-contato">
            <h2>Contato</h2>
            <span>(11) 3333-4444</span>
            <br>
            <span>supergestao@dominio.com.br</span>
        </div>
        <div class="localizacao">
            <h2>Localização</h2>
            <img src="img/mapa.png">
        </div>
    </div>
@endsection

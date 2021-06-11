@extends('app.layouts.basico')


@section('titulo', 'Fornecedor')

@section('conteudo')

    <div class="conteudo-pagina">
        <div class="titulo-pagina-2">
            <p>Cadastrar novo fornecedor</p>
        </div>

        <div class="menu">
            <ul>
                <li><a href="{{ route('app.fornecedores.adicionar') }}">Novo</a></li>
                <li><a href="{{ route('app.fornecedores') }}">Consulta</a></li>
            </ul>
        </div>
        @if ($msg != '')
            <h3>{{ $msg }}</h3>
        @endif
        <div class="informacao-pagina">
            <div style="width: 30%; margin-left: auto; margin-right: auto;">
                <form action="{{ route('app.fornecedores.adicionar') }}" method="post">
                    @csrf
                    <input type="text" value="{{old('nome') ? old('nome') : ''}}" name="nome" placeholder="nome do fornecedor" class="borda-preta">
                    <br>
                    {{ $errors->has('nome') ? $errors->first('nome') : '' }}
                    <br>
                    <input type="text" name="email" value="{{old('email') ? old('email') : ''}}" placeholder="email do fornecedor" class="borda-preta">
                    <br>
                    {{ $errors->has('email') ? $errors->first('email') : '' }}
                    <br>
                    <input type="text" name="uf" value="{{old('uf') ? old('uf') : ''}}" placeholder="Sigla do estado" class="borda-preta">
                    <br>
                    {{ $errors->has('uf') ? $errors->first('uf') : '' }}
                    <br>
                    <input type="text" name="site" value="{{old('site') ? old('site') : ''}}" placeholder="link do site" class="borda-preta">
                    <br>
                    {{ $errors->has('site') ? $errors->first('site') : '' }}
                    <br>
                    <button type="submit" class="borda-preta">Cadastrar</button>
                </form>
            </div>
        </div>
    </div>

@endsection

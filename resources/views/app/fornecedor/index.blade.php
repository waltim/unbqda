@extends('app.layouts.basico')


@section('titulo', 'Fornecedor')

@section('conteudo')

    <div class="conteudo-pagina">
        <div class="titulo-pagina-2">
            <p>Fornecedores</p>
        </div>

        <div class="menu">
            <ul>
                <li><a href="{{ route('app.fornecedores.adicionar') }}">Novo</a></li>
                <li><a href="{{ route('app.fornecedores') }}">Consulta</a></li>
            </ul>
        </div>

        <div class="informacao-pagina">
            <div style="width: 30%; margin-left: auto; margin-right: auto;">
                <form action="{{ route('app.fornecedores.listar') }}" method="post">
                    @csrf
                    <input type="text" name="nome" placeholder="nome do fornecedor" class="borda-preta">
                    <input type="text" name="email" placeholder="email do fornecedor" class="borda-preta">
                    <input type="text" name="uf" placeholder="Sigla do estado" class="borda-preta">
                    <input type="text" name="site" placeholder="link do site" class="borda-preta">
                    <button type="submit" class="borda-preta">Pesquisar</button>
                </form>
            </div>
        </div>
    </div>

@endsection

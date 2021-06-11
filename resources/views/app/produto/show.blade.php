@extends('app.layouts.basico')


@section('titulo', 'Produto')

@section('conteudo')

    <div class="conteudo-pagina">
        <div class="titulo-pagina-2">
            <p>Detalhes do produto</p>
        </div>

        <div class="menu">
            <ul>
                <li><a href="{{ route('produto.create') }}">Novo</a></li>
                <li><a href="{{ route('produto.index') }}">Consulta</a></li>
            </ul>
        </div>
        <div class="informacao-pagina">
            <div style="width: 50%; margin-left: auto; margin-right: auto;">
                <table border="1">
                    <thead>
                        <th>ID</th>
                        <th>Produto</th>
                        <th>Descrição</th>
                        <th>Peso</th>
                        <th>Unidade</th>
                    </thead>
                    <tbody>
                        <tr>
                            <td>{{ $produto->id }}</td>
                            <td>{{ $produto->nome }}</td>
                            <td>{{ $produto->descricao }}</td>
                            <td>{{ $produto->peso }} - KG</td>
                            <td>{{ $produto->unidade_id }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

@endsection

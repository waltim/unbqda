@extends('app.layouts.basico')


@section('titulo', 'Fornecedor')

@section('conteudo')

    <div class="conteudo-pagina">
        <div class="titulo-pagina-2">
            <p>Listar fornecedores</p>
        </div>

        <div class="menu">
            <ul>
                <li><a href="{{ route('app.fornecedores.adicionar') }}">Novo</a></li>
                <li><a href="{{ route('app.fornecedores') }}">Consulta</a></li>
            </ul>
        </div>

        <div class="informacao-pagina">
            <div style="width: 90%; margin-left: auto; margin-right: auto;">
                <table border="1" width="100%">
                    <thead>
                        <tr>
                            <th>Nome</th>
                            <th>Site</th>
                            <th>UF</th>
                            <th>Email</th>
                            <th>Editar</th>
                            <th>Excluir</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($fornecedores as $fornecedor)
                        <tr>
                            <td>{{ $fornecedor->nome }}</td>
                            <td>{{ $fornecedor->site }}</td>
                            <td>{{ $fornecedor->uf }}</td>
                            <td>{{ $fornecedor->email }}</td>
                            <td><a href="{{ route("app.fornecedores.editar",[$fornecedor->id]) }}">Editar</a></td>
                            <td><a href="{{ route("app.fornecedores.excluir",[$fornecedor->id]) }}">Exluir</a></td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                {{ $fornecedores->appends(request()->input())->links() }}
                {{-- {{ $fornecedores->count() }} - registros por página.
                <br> --}}
                {{ $fornecedores->total() > 0 ? $fornecedores->total().' - de registros encontrados.' : 'nenhum registro encontrado.' }}
                {{-- <br>
                {{ $fornecedores->firstItem() }} - Primeiro registro.
                <br>
                {{ $fornecedores->lastItem() }} - Último registro. --}}
            </div>
        </div>
    </div>

@endsection

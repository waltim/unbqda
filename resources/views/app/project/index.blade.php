@extends('app.layouts.basico')

@section('titulo', $titulo)

@section('conteudo')

    <div class="conteudo-pagina">
        <div class="titulo-pagina">
            <h1>Product List</h1>
        </div>

        <div class="menu">
            <ul>
                <li><a href="{{ route('project.create') }}">New project</a></li>
                <li><a href="{{ route('project.index') }}">List</a></li>
            </ul>
        </div>
    </div>
    <div class="informacao-pagina">
        <div style="width: 90%; margin-left: auto; margin-right: auto;">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Name</th>
                        <th scope="col">Description</th>
                        <th scope="col">Owner</th>
                        <th scope="col">View</th>
                        <th scope="col">Edit</th>
                        <th scope="col">Delete</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($projects as $key => $project)
                        <tr>
                            <th scope="row">{{ $key+1 }}</th>
                            <td>{{ $project->name }}</td>
                            <td>{{ $project->description }}</td>
                            <td>{{ $project->user_id }}</td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            {{ $projects->appends($request)->links() }}
            {{ $projects->total() > 0 ? $projects->total() . ' - de registros encontrados.' : 'nenhum registro encontrado.' }}
        </div>
    </div>

@endsection

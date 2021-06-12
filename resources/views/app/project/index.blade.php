@extends('app.layouts.basico')

@section('titulo', $titulo)

@section('conteudo')

    <div class="conteudo-pagina">
        <div class="titulo-pagina">
            <h1>Product List</h1>
        </div>

        <div class="menu">
            <ul>
                <li><a href="" data-toggle="modal" data-target=".bd-example-modal-lg">New project</a></li>
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
                            <th scope="row">{{ $key + 1 }}</th>
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
            {{ $projects->total() > 0 ? $projects->total() . ' - registro(s) encontrado(s).' : 'nenhum registro encontrado.' }}
        </div>
    </div>

    <!-- Large modal -->
    <div id="myModal" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div style="width: 95%; margin: auto;">
                    <div style="text-align: center; margin-top: 3%;">
                        <h3>Project registration</h3>
                    </div>
                    <form method="post" action="{{ route('project.store') }}">
                        @csrf
                        <input type="hidden" name="user_id" value="{{ auth()->id() }}">
                        <div class="form-group">
                            <label style="font-size: 18px;" for="exampleFormControlInput1">Project name</label>
                            <input type="text" name="name" value="{{ old('name') ??  '' }}" class="form-control" id="exampleFormControlInput1"
                                placeholder="The name of your project">
                            {{ $errors->has('name') ? $errors->first('name') : '' }}
                        </div>
                        <div class="form-group">
                            <label style="font-size: 18px;" for="exampleFormControlTextarea1">Description</label>
                            <textarea class="form-control" name="description" placeholder="The main goal is....."
                                id="exampleFormControlTextarea1" rows="5">{{ old('description') ??  '' }}</textarea>
                            {{ $errors->has('description') ? $errors->first('description') : '' }}
                        </div>
                        <div class="form-group col-md-12 text-center">
                            <input type="submit" class="btn btn-success col-md-4" value="Register">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>



    <!-- Small modal -->
    {{-- <button type="button" class="btn btn-primary" data-toggle="modal" data-target=".bd-example-modal-sm">Small
        modal</button>

    <div class="modal fade bd-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                ...
            </div>
        </div>
    </div> --}}
    @component('app.layouts._partials.js-import')
    @endcomponent
    @if (sizeof($errors->all()) > 0)
        <script>
            $(document).ready(function() {
                $("#myModal").modal('show');
            });
        </script>
    @endif

@endsection

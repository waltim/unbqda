@extends('app.layouts.basico')

@section('titulo', $titulo)

@section('conteudo')

    <div class="conteudo-pagina">
        <div class="titulo-pagina">
            <h1>Product List</h1>
        </div>

        <div class="text-right" style="padding-right: 5%">
            <div class="btn-group" role="group" aria-label="Basic example">
                <button type="button" data-toggle="modal" class="btn btn-outline-primary" data-target=".bd-example-modal-lg"
                    class="btn btn-outline-primary">New Project</button>
            </div>
        </div>
    </div>
    <div class="informacao-pagina">
        <div id="reload-table" style="width: 90%; margin-left: auto; margin-right: auto;">
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
                    @foreach ($projects as $project)
                        <tr id="sid{{ $project->id }}">
                            <td scope="row">{{ $project->id }}</td>
                            <td>{{ $project->name }}</td>
                            <td>{{ \Illuminate\Support\Str::limit($project->description, 50, $end = '...') }}</td>
                            <td>{{ $project->user->name }}</td>
                            @if (auth()->id() == $project->user->id)
                                <td><a class="btn btn-light"
                                        href="{{ route('project.show', ['project' => $project->id]) }}">Details</a></td>
                                <td><a href="javascript:void(0)" id="editProject" class="btn btn-info"
                                        onclick="editProject({{ $project->id }})">Edit Project</a></td>
                                <td><a href="javascript:void(0)" onclick="deleteProject({{ $project->id }})"
                                        class="btn btn-danger">Delete</a></td>
                            @else
                                <td><a class="btn btn-light"
                                        href="{{ route('project.show', ['project' => $project->id]) }}">Details</a></td>
                                <td></td>
                                <td></td>
                            @endif
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
                    <div id="modal-action" style="text-align: center; margin-top: 3%;">
                        <h3>Project registration</h3>
                    </div>
                    <form id="projectForm">
                        @csrf
                        <input type="hidden" id="user_id" name="user_id" value="{{ auth()->id() }}">
                        <div class="form-group">
                            <label style="font-size: 18px;" for="exampleFormControlInput1">Project name</label>
                            <input type="text" id="new_name" name="name" value="{{ old('name') ?? '' }}"
                                class="form-control" placeholder="The name of your project">
                            @if ($errors->has('name'))
                                <div class="alert alert-danger" role="alert">
                                    {{ $errors->first('name') }}
                                </div>
                            @endif
                        </div>
                        <div class="form-group">
                            <label style="font-size: 18px;" for="exampleFormControlTextarea1">Description</label>
                            <textarea class="form-control" id="new_description" name="description"
                                placeholder="The main goal is....." rows="5">{{ old('description') ?? '' }}</textarea>
                            @if ($errors->has('description'))
                                <div class="alert alert-danger" role="alert">
                                    {{ $errors->first('description') }}
                                </div>
                            @endif
                        </div>
                        <div class="form-group col-md-12 text-center">
                            <input type="submit" class="btn btn-success col-md-4" value="Register">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <div id="editForm" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog"
        aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div style="width: 95%; margin: auto;">
                    <div id="modal-action" style="text-align: center; margin-top: 3%;">
                        <h3>Edit project</h3>
                    </div>
                    <form id="projectEditForm">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label style="font-size: 18px;" for="exampleFormControlInput1">Project name</label>
                            <input type="text" name="name" value="{{ old('name') ?? '' }}" class="form-control" id="name"
                                placeholder="The name of your project">
                            @if ($errors->has('name'))
                                <div class="alert alert-danger" role="alert">
                                    {{ $errors->first('name') }}
                                </div>
                            @endif
                        </div>
                        <div class="form-group">
                            <label style="font-size: 18px;" for="exampleFormControlTextarea1">Description</label>
                            <textarea class="form-control" name="description" placeholder="The main goal is....."
                                id="description" rows="5">{{ old('description') ?? '' }}</textarea>
                            @if ($errors->has('description'))
                                <div class="alert alert-danger" role="alert">
                                    {{ $errors->first('description') }}
                                </div>
                            @endif
                        </div>
                        <div class="form-group col-md-12 text-center">
                            <input type="submit" class="btn btn-success col-md-4" value="Update">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @component('app.layouts._partials.js-import')
    @endcomponent

    <script>
        function deleteProject(id) {

            if (confirm("Do you really want to delete this project?")) {
                $.ajax({
                    url: '/project/' + id,
                    type: 'DELETE',
                    data: {
                        _token: $("input[name=_token]").val()
                    },
                    success: function(response) {
                        $('#reload-table').load(document.URL + ' #reload-table');
                    }
                })
            }
        }

        function editProject(id) {
            var key = parseInt(id);
            $.get('/project/' + key + '/edit', function(project) {
                document.getElementById("name").value = project.name;
                document.getElementById("description").value = project.description;
                $("#projectId").remove();
                var new_input = "<input type='hidden' id='projectId' name='id' value='" + id + "'>";
                $('#projectEditForm').append(new_input);
                $("#editForm").modal("toggle");
            });
        }

        $('#projectEditForm').submit(function(e) {
            e.preventDefault();
            var id = $("#projectId").val();
            var name = $("#name").val();
            var description = $("#description").val();
            var _token = $("input[name=_token]").val();
            var _method = $("input[name=_method]").val();
            console.log(id, name, description, _token, _method);
            $.ajax({
                url: "{{ route('project.update') }}",
                type: "POST",
                data: {
                    id: id,
                    name: name,
                    description: description,
                    _token: _token,
                    _method: _method
                },
                success: function(response) {
                    $("#editForm").modal("toggle");
                    $('#projectEditForm')[0].reset();
                    $('#reload-table').load(document.URL + ' #reload-table');
                },
                error: function(data) {
                    var errors = data.responseText;
                    var jsonResponse = JSON.parse(errors);
                    $.each(jsonResponse.errors, function(key, value) {
                        alert(key + ": " + value);
                    });
                }
            })
        })


        $('#projectForm').submit(function(e) {
            e.preventDefault();
            var user_id = $("input[name=user_id]").val();
            var name = $("input[name=name]").val();
            var description = $("textarea[name=description]").val();
            var _token = $("input[name=_token]").val();

            $.ajax({
                url: "{{ route('project.store') }}",
                type: "POST",
                data: {
                    user_id: user_id,
                    name: name,
                    description: description,
                    _token: _token
                },
                success: function(response) {
                    $("#myModal").modal("toggle");
                    $('#projectForm')[0].reset();
                    $('#reload-table').load(document.URL + ' #reload-table');
                },
                error: function(data) {
                    var errors = data.responseText;
                    var jsonResponse = JSON.parse(errors);
                    $.each(jsonResponse.errors, function(key, value) {
                        $('#new_' + key).after("<div class='alert alert-danger' id='alert_" +
                            key + "' role='alert'>" + value + "</div>");
                        setTimeout(function() {
                            $('#alert_' + key).remove();
                        }, 4000);
                    });
                }
            })
        })

    </script>

@endsection

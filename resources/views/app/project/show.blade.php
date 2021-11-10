@extends('app.layouts.basico')

@section('titulo', $titulo)

@section('conteudo')

    <div class="conteudo-pagina">
        <div class="titulo-pagina">
            <h1>Project Details</h1>
        </div>

        <div class="text-right" style="padding-right: 5%">
            <div class="btn-group" role="group" aria-label="Basic example">
                <button type="button" onclick="location.href = '{{ route('project.index') }}';"
                    class="btn btn-outline-primary">List Projects</button>
                <button type="button" data-toggle="modal" class="btn btn-outline-primary"
                    data-target=".bd-example-modal-lg">New Interview</button>
                 @if (auth()->id() == $project->user_id)
                    <button type="button"
                    onclick="location.href = '{{ route('project.advanced.stage', ['project' => $project->id]) }}';"
                    class="btn btn-outline-primary">Codes &#8611; Categories</button>
                @endif
            </div>
        </div>
    </div>
    <div class="informacao-pagina">
        <div class="media">
            <div class="media-body">
                <h5 class="mt-0">{{ $project->name }}</h5>
                {{ $project->description }}
            </div>
        </div>
        <div class="child-sections">
            <h1 class=".sub-titulos">Project Interviews</h1>
        </div>
        <div id="interviews-table" style="width: 90%; margin-left: auto; margin-right: auto;">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Name</th>
                        <th scope="col">Description</th>
                        <th scope="col">Actions</th>
                        <th scope="col">Edit</th>
                        <th scope="col">Delete</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($interviews as $key => $interview)
                        @php
                            $codeCount = 0;
                            $quoteList = \DB::table('quotes')
                                ->where('interview_id', $interview->id)
                                ->get();
                            foreach ($quoteList as $key => $quote) {
                                $codeList = \DB::table('code_quote')
                                    ->where('quote_id', $quote->id)
                                    ->get();
                                $codeCount = $codeCount + $codeList->count();
                            }
                            $process = \DB::table('coding_levels')
                                ->where('interview_id', $interview->id)
                                ->latest('created_at')
                                ->first();
                            $level = 0;
                            if ($process != null) {
                                $level = $process->level;
                            }
                        @endphp
                        <tr id="sid{{ $interview->id }}">
                            <td scope="row">{{ $key }}</td>
                            <td>{{ $interview->name }}</td>
                            <td>{{ \Illuminate\Support\Str::limit($interview->description, 50, $end = '...') }}</td>
                            @if (auth()->id() == $interview->project->user_id)
                                <td class="btn-group" role="group" aria-label="Basic example"
                                    style="padding-top: 0px!important">
                                    <button type="button"
                                        onclick="location.href = '{{ route('interview.show', ['interview' => $interview->id]) }}';"
                                        class="btn btn-outline-dark">Open Coding</button>
                                    @if ($codeCount > 1 && $level > 0)
                                        <button type="button"
                                            onclick="location.href = '{{ route('interview.analise', ['interview' => $interview->id]) }}';"
                                            class="btn btn-outline-primary">Code Analise</button>
                                    @else
                                        <button type="button" onclick="setInterviewInput({{ $interview->id }})" data-toggle="modal" class="btn btn-outline-primary"
                                        data-target=".apt-analysis">suitable for analysis</button>
                                    @endif
                                </td>
                                <td><a href="javascript:void(0)" id="editInterview" class="btn btn-info"
                                        onclick="editInterview({{ $interview->id }})">Edit Interview</a></td>
                                <td><a href="javascript:void(0)" onclick="deleteInterview({{ $interview->id }})"
                                        class="btn btn-danger">Delete</a></td>
                            @else
                                <td class="btn-group" role="group" aria-label="Basic example"
                                    style="padding-top: 0px!important">
                                    <button type="button"
                                        onclick="location.href = '{{ route('interview.show', ['interview' => $interview->id]) }}';"
                                        class="btn btn-outline-dark">Open Coding</button>
                                    @if ($codeCount > 1 && $level > 0)
                                    <button type="button"
                                        onclick="location.href = '{{ route('interview.analise', ['interview' => $interview->id]) }}';"
                                        class="btn btn-outline-success">Code Analise</button>
                                    @endif
                                </td>
                                <td></td>
                                <td></td>
                            @endif
                        </tr>
                    @endforeach
                </tbody>
            </table>
            {{ $interviews->withQueryString()->links() }}
            {{ $interviews->total() > 0 ? $interviews->total() . ' - registro(s) encontrado(s).' : 'nenhum registro encontrado.' }}
        </div>
    </div>

    <!-- Large modal -->
    <div id="myModal" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div style="width: 95%; margin: auto;">
                    <div id="modal-action" style="text-align: center; margin-top: 3%;">
                        <h3>Interview registration</h3>
                    </div>
                    <form id="interviewForm">
                        @csrf
                        <input type="hidden" id="project_id" name="project_id" value="{{ $project->id }}">
                        <div class="form-group">
                            <label style="font-size: 18px;" for="exampleFormControlInput1">Interview name</label>
                            <input type="text" id="interview_name" name="name" value="{{ old('name') ?? '' }}"
                                class="form-control" placeholder="The name of your project">
                        </div>
                        <div class="form-group">
                            <label style="font-size: 18px;" for="exampleFormControlTextarea1">The text of the
                                interview</label>
                            <textarea class="form-control" id="interview_description" name="description"
                                placeholder="Research: Can you prefer....."
                                rows="5">{{ old('description') ?? '' }}</textarea>
                        </div>
                        <div class="form-group col-md-12 text-center">
                            <input type="submit" class="btn btn-success col-md-4" value="Register">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <div class="modal fade apt-analysis" id="apt-analysis" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="code-name">Coding Level</h5>
                </div>
                <div class="modal-body">
                    <form id="analiseForm">
                        @csrf
                        <div id="code-id" class="form-group">
                            <p id="quote-text" style="color: black;"></p>
                        </div>
                        <div class="form-group">
                            <label for="exampleFormControlSelect1">Coding Status</label>
                            <select name="scale" class="form-control" id="code_scale" required>
                                <option value=""> Select one option </option>
                                <option value="1">Open Coding</option>
                                <option value="2">Axial Coding</option>
                                <option value="3">Selective Coding</option>
                            </select>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Change level</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <div id="editInterviewForm" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog"
        aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div style="width: 95%; margin: auto;">
                    <div id="modal-action" style="text-align: center; margin-top: 3%;">
                        <h3>Edit project</h3>
                    </div>
                    <form id="interviewEditForm">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label style="font-size: 18px;" for="exampleFormControlInput1">Interview name</label>
                            <input type="text" name="name" value="{{ old('name') ?? '' }}" class="form-control"
                                id="name" placeholder="The name of your project">
                        </div>
                        <div class="form-group">
                            <label style="font-size: 18px;" for="exampleFormControlTextarea1">Text of the interview</label>
                            <textarea class="form-control" name="description" placeholder="The main goal is....."
                                id="description" rows="5">{{ old('description') ?? '' }}</textarea>
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
        function deleteInterview(id) {

            if (confirm("Do you really want to delete this interview?")) {
                $.ajax({
                    url: '/interview/' + id,
                    type: 'DELETE',
                    data: {
                        _token: $("input[name=_token]").val()
                    },
                    success: function(response) {
                        $('#interviews-table').load(document.URL + ' #interviews-table');
                    }
                })
            }
        }

        function setInterviewInput(id){
            $("#interview_id").remove();
            $("#analiseForm").append("<input type='hidden' id='interview_id' name='interview_id' value=" + id + " >");
        }

        $('#analiseForm').submit(function(e) {
            e.preventDefault();
            var scale = $("select[name=scale]").val();
            var _token = $("input[name=_token]").val();
            var interview_id = $("input[name=interview_id]").val();
            console.log(scale, interview_id);
            $.ajax({
                url: "{{ route('interview.level') }}",
                type: "POST",
                data: {
                    level: scale,
                    _token: _token,
                    interview_id: interview_id
                },
                success: function(response) {
                    $("#apt-analysis").modal("toggle");
                    $('#analiseForm')[0].reset();
                    $('#interviews-table').load(document.URL + ' #interviews-table');
                },
                error: function(data) {
                    console.log(data);
                }
            })
        })

        function editInterview(id) {
            var key = parseInt(id);
            $.get('/interview/' + key + '/edit', function(interview) {
                document.getElementById("name").value = interview.name;
                document.getElementById("description").value = interview.description;
                $("#interviewId").remove();
                var new_input = "<input type='hidden' id='interviewId' name='id' value='" + id + "'>";
                $('#interviewEditForm').append(new_input);
                $("#editInterviewForm").modal("toggle");
            });
        }

        $('#interviewEditForm').submit(function(e) {
            e.preventDefault();
            var id = $("#interviewId").val();
            var name = $("#name").val();
            var description = $("#description").val();
            description = description.replace(/¶/g, '');
            var _token = $("input[name=_token]").val();
            var _method = $("input[name=_method]").val();
            console.log(id, name, description, _token, _method);
            $.ajax({
                url: "{{ route('interview.update') }}",
                type: "POST",
                data: {
                    id: id,
                    name: name,
                    description: description.replace(/¶/g, ''),
                    _token: _token,
                    _method: _method
                },
                success: function(response) {
                    $("#editInterviewForm").modal("toggle");
                    $('#interviewEditForm')[0].reset();
                    $('#interviews-table').load(document.URL + ' #interviews-table');
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


        $('#interviewForm').submit(function(e) {
            e.preventDefault();
            var project_id = $("input[name=project_id]").val();
            var name = $("input[name=name]").val();
            var description = $("textarea[name=description]").val();
            description = description.replace(/¶/g, '');
            var _token = $("input[name=_token]").val();

            $.ajax({
                url: "{{ route('interview.store') }}",
                type: "POST",
                data: {
                    project_id: project_id,
                    name: name,
                    description: description,
                    _token: _token
                },
                success: function(response) {
                    $("#myModal").modal("toggle");
                    $('#interviewForm')[0].reset();
                    $('#interviews-table').load(document.URL + ' #interviews-table');
                },
                error: function(data) {
                    var errors = data.responseText;
                    var jsonResponse = JSON.parse(errors);
                    $.each(jsonResponse.errors, function(key, value) {
                        $('#interview_' + key).after(
                            "<div class='alert alert-danger' id='alert_" +
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

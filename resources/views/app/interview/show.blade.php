@extends('app.layouts.basico')

@section('titulo', $titulo)

@section('conteudo')

    <div class="conteudo-pagina">
        <div class="titulo-pagina">
            <h1 class="unselectable">Interview Analysis</h1>
        </div>

        <div class="text-right" style="padding-right: 5%">
            <div class="btn-group" role="group" aria-label="Basic example">
                <button type="button"
                    onclick="location.href = '{{ route('project.show', ['project' => $interview->project_id]) }}';"
                    class="btn btn-outline-primary">List Interviews</button>

            </div>
        </div>
    </div>
    <div style="width: 95%; margin: auto;">
        <div class="row">
            <div class="col-md-4">
                <div class="child-sections">
                    <h1 class=".sub-titulos unselectable">Codes</h1>
                </div>
                <form id="CodeCreate">
                    <div class="form-group">
                        <label class="unselectable" for="exampleFormControlInput1">Name of code</label>
                        <input type="email" class="form-control" id="exampleFormControlInput1" placeholder="Succcinct Code">
                    </div>
                    <div class="form-group">
                        <label class="unselectable" for="exampleFormControlSelect1">Color</label>
                        <select class="form-control" id="exampleFormControlSelect1">
                            <option>1</option>
                            <option>2</option>
                            <option>3</option>
                            <option>4</option>
                            <option>5</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="unselectable" for="exampleFormControlSelect1">Quote</label>
                        <select class="form-control" id="exampleFormControlSelect1">
                            <option>1</option>
                            <option>2</option>
                            <option>3</option>
                            <option>4</option>
                            <option>5</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="unselectable" for="exampleFormControlTextarea1">Memo</label>
                        <textarea class="form-control"
                            placeholder="This refactoring make a code more succinct and more readably..."
                            id="exampleFormControlTextarea1" rows="3"></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary mb-2">Create new code</button>
                </form>
                <input id="showSelected" style="width: 30%;" class="btn btn-dark" type="button" value="Select quote" />
            </div>
            <div class="col-md-8">
                <p id="interview-text" style="color: black!important; white-space: pre-wrap; text-align: justify;">
                    {{ $interview->description }}
                </p>
            </div>
        </div>
    </div>

    <!-- Large modal -->
    {{-- <div id="myModal" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
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
                            <label style="font-size: 18px;" for="exampleFormControlTextarea1">The text of the interview</label>
                            <textarea class="form-control" id="interview_description" name="description"
                                placeholder="Research: Can you prefer....." rows="5">{{ old('description') ?? '' }}</textarea>
                        </div>
                        <div class="form-group col-md-12 text-center">
                            <input type="submit" class="btn btn-success col-md-4" value="Register">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div> --}}


    {{-- <div id="editInterviewForm" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog"
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
                            <input type="text" name="name" value="{{ old('name') ?? '' }}" class="form-control" id="name"
                                placeholder="The name of your project">
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
    </div> --}}

    @component('app.layouts._partials.js-import')
    @endcomponent

    <script>
        // function deleteInterview(id) {

        //     if (confirm("Do you really want to delete this interview?")) {
        //         $.ajax({
        //             url: '/interview/' + id,
        //             type: 'DELETE',
        //             data: {
        //                 _token: $("input[name=_token]").val()
        //             },
        //             success: function(response) {
        //                 $('#interviews-table').load(document.URL + ' #interviews-table');
        //             }
        //         })
        //     }
        // }

        // function editInterview(id) {
        //     var key = parseInt(id);
        //     $.get('/interview/' + key + '/edit', function(interview) {
        //         document.getElementById("name").value = interview.name;
        //         document.getElementById("description").value = interview.description;
        //         $("#interviewId").remove();
        //         var new_input = "<input type='hidden' id='interviewId' name='id' value='" + id + "'>";
        //         $('#interviewEditForm').append(new_input);
        //         $("#editInterviewForm").modal("toggle");
        //     });
        // }

        // $('#interviewEditForm').submit(function(e) {
        //     e.preventDefault();
        //     var id = $("#interviewId").val();
        //     var name = $("#name").val();
        //     var description = $("#description").val();
        //     var _token = $("input[name=_token]").val();
        //     var _method = $("input[name=_method]").val();
        //     console.log(id, name, description, _token, _method);
        //     $.ajax({
        //         url: "{{ route('interview.update') }}",
        //         type: "POST",
        //         data: {
        //             id: id,
        //             name: name,
        //             description: description,
        //             _token: _token,
        //             _method: _method
        //         },
        //         success: function(response) {
        //             $("#editInterviewForm").modal("toggle");
        //             $('#interviewEditForm')[0].reset();
        //             $('#interviews-table').load(document.URL + ' #interviews-table');
        //         },
        //         error: function(data) {
        //             var errors = data.responseText;
        //             var jsonResponse = JSON.parse(errors);
        //             $.each(jsonResponse.errors, function(key, value) {
        //                 alert(key + ": " + value);
        //             });
        //         }
        //     })
        // })


        // $('#interviewForm').submit(function(e) {
        //     e.preventDefault();
        //     var project_id = $("input[name=project_id]").val();
        //     var name = $("input[name=name]").val();
        //     var description = $("textarea[name=description]").val();
        //     var _token = $("input[name=_token]").val();

        //     $.ajax({
        //         url: "{{ route('interview.store') }}",
        //         type: "POST",
        //         data: {
        //             project_id: project_id,
        //             name: name,
        //             description: description,
        //             _token: _token
        //         },
        //         success: function(response) {
        //             $("#myModal").modal("toggle");
        //             $('#interviewForm')[0].reset();
        //             $('#interviews-table').load(document.URL + ' #interviews-table');
        //         },
        //         error: function(data) {
        //             var errors = data.responseText;
        //             var jsonResponse = JSON.parse(errors);
        //             $.each(jsonResponse.errors, function(key, value) {
        //                 $('#interview_' + key).after("<div class='alert alert-danger' id='alert_" +
        //                     key + "' role='alert'>" + value + "</div>");
        //                 setTimeout(function() {
        //                     $('#alert_' + key).remove();
        //                 }, 4000);
        //             });
        //         }
        //     })
        // })

        $('#showSelected').on('click', function() {
            var text = "";
            if (window.getSelection) {
                text = window.getSelection().toString();
            } else if (document.selection && document.selection.type != "Control") {
                text = document.selection.createRange().text;
            }

            var searchword = text;
            var custfilter = new RegExp(searchword, "ig");
            var repstr = "<span class='highlight'>" + searchword + "</span>";

            if (searchword != "") {
                $('#interview-text').each(function() {
                    $(this).html($(this).html().replace(custfilter, repstr));
                })
            }
        });

    </script>

@endsection

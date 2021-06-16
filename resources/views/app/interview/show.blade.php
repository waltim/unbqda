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

                {{-- <button type="button" onclick="highlightText({{ $interview->id }});"
                    class="btn btn-outline-primary">Refresh
                    quotes</button> --}}

            </div>
        </div>
    </div>

    <div style="margin: 0 auto;height: 60px;width: 95%;">
        <input id="showSelected" style="width: 15%;" class="btn btn-dark float-right" type="button" value="Get quote" />
    </div>
    <div style="width: 95%; margin: auto;">
        <div class="row">
            <div class="col-md-4">
                <div class="child-sections">
                    <h1 class=".sub-titulos unselectable">Codes</h1>
                </div>
                <form id="codeForm">
                    @csrf
                    <input type="hidden" name="interview_id" value="{{ $interview->id }}">
                    <div class="form-group">
                        <label class="unselectable" for="exampleFormControlInput1">Name of code</label>
                        <input type="text" name="code_name" class="form-control code_name" id="exampleFormControlInput1"
                            placeholder="Succcinct Code">
                    </div>
                    <div class="form-group">
                        <label class="unselectable" for="exampleFormControlSelect1">Color</label>
                        <input type="color" id="color" class="btn btn-secondary" style="width: 5%">
                        <input type="text" name="code_color" class="form-control code_color" id="choosen-color"
                            placeholder="#0000FF">
                    </div>
                    <div class="form-group">
                        <label class="unselectable" for="exampleFormControlTextarea1">Quote</label>
                        <textarea class="form-control code_quote" name="code_quote"
                            placeholder="This refactoring make a code more succinct and more readably..." id="quoteText"
                            rows="3"></textarea>
                    </div>
                    <div class="form-group">
                        <label class="unselectable" for="exampleFormControlTextarea1">Memo</label>
                        <textarea class="form-control code_memo" name="code_memo"
                            placeholder="This refactoring make a code more succinct and more readably..."
                            id="exampleFormControlTextarea1" rows="3"></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary mb-2">Create new code</button>
                </form>
            </div>
            <div class="col-md-8 ex1">
                <p id="interview-text"
                    style="color: black!important; white-space: pre-wrap; text-align: justify; font-size: 18px">
                    {{ $interview->description }}
                </p>
            </div>
        </div>
    </div>
    <div class="child-sections">
        <h1 class=".sub-titulos">Codes</h1>
    </div>
    <div id="codes-table" style="width: 90%; margin-left: auto; margin-right: auto;">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Code name</th>
                    <th scope="col">Memo</th>
                    <th scope="col">Color</th>
                    <th scope="col">Quote</th>
                    <th scope="col">Delete</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($codes as $code)
                    <tr id="sid{{ $code->id }}" style="border-bottom: 3pt solid {{ $code->color }}">
                        <td scope="row">{{ $code->id }}</td>
                        <td>{{ $code->description }}</td>
                        <td>{{ \Illuminate\Support\Str::limit($code->memo, 50, $end = '...') }}</td>
                        <td>{{ $code->color }}</td>
                        <td>{{ $code->quote->description }}</td>
                        <td><a href="javascript:void(0)" onclick="deleteCode({{ $code->id }})"
                                class="btn btn-danger">Delete</a></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        {{ $codes->withQueryString()->links() }}
        {{ $codes->total() > 0 ? $codes->total() . ' - registro(s) encontrado(s).' : 'nenhum registro encontrado.' }}
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
        $(window).bind("load", function() {
            highlightText({{ $interview->id }});
        });

        function deleteCode(id) {

            if (confirm("Do you really want to delete this code?")) {
                $.ajax({
                    url: '/code/' + id,
                    type: 'DELETE',
                    data: {
                        _token: $("input[name=_token]").val()
                    },
                    success: function(response) {
                        $('#codes-table').load(document.URL + ' #codes-table');
                        highlightText({{ $interview->id }});
                    }
                })
            }
        }

        function remove_tags(html) {
            html = html.replace(/<br>/g, "$br$");
            html = html.replace(/(?:\r\n|\r|\n)/g, '$n$');
            var tmp = document.createElement("DIV");
            tmp.innerHTML = html;
            html = tmp.textContent || tmp.innerText;
            html = html.replace(/\$br\$/g, "<br>");
            html = html.replace(/\$n\$/g, "<br>");
            html = html.replace(/¶/g, '');
            html = html.replace(/\u00B6/g, '')
            return html;
        }

        function highlightText(id) {
            $.get('/code-highlight/' + id, function(quotes) {
                var interview = $('#interview-text').text();
                var mydiv = document.getElementById("interview-text");
                var str = mydiv.innerHTML;
                mydiv.innerHTML = remove_tags(str);
                $.each(quotes, function(key, value) {
                    var searchword = value.description;
                    searchword = searchword.replace(/¶/g, '');
                    var repstr = "<span title=' Code: " + value.code_name + " - " + value.name + "' style='background:white;padding:1px;border:" + value.color +
                        " solid 1px;border-left: 15px solid " + value.color + ";font-weight: bold;'>" + searchword + "</span>";
                    if (searchword != "") {
                        $('#interview-text').each(function() {
                            $(this).html($(this).html().replace(searchword, repstr));
                        })
                    }
                });
            });
        }

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


        $('#codeForm').submit(function(e) {
            e.preventDefault();
            var interview_id = $("input[name=interview_id]").val();
            var name = $("input[name=code_name]").val();
            var color = $("input[name=code_color]").val();
            var memo = $("textarea[name=code_memo]").val();
            var quote = $("textarea[name=code_quote]").val();
            quote = quote.replace(/¶/g, '');
            var _token = $("input[name=_token]").val();
            console.log(interview_id, name, color, memo, _token, quote);
            $.ajax({
                url: "{{ route('code.store') }}",
                type: "POST",
                data: {
                    interview_id: interview_id,
                    code_name: name,
                    code_color: color,
                    _token: _token,
                    code_memo: memo,
                    code_quote: quote
                },
                success: function(response) {
                    $('#codeForm')[0].reset();
                    $('#codes-table').load(document.URL + ' #codes-table');
                    highlightText(interview_id);
                },
                error: function(data) {
                    console.log(data);
                    var errors = data.responseText;
                    var jsonResponse = JSON.parse(errors);
                    $.each(jsonResponse.errors, function(key, value) {
                        $(".code_" + key).after(
                            "<div class='alert alert-danger' id='alert_" +
                            key + "' role='alert'>" + value + "</div>");
                        setTimeout(function() {
                            $('#alert_' + key).remove();
                        }, 4000);
                    });
                }
            })
        })

        $('#showSelected').on('click', function() {
            var text = "";
            if (window.getSelection) {
                text = window.getSelection().toString();
            } else if (document.selection && document.selection.type != "Control") {
                text = document.selection.createRange().text;
            }
            $("textarea#quoteText").val(text);
        });

        jQuery('#color').on('change', function() {
            $("input#choosen-color").val(jQuery(this).val());
        });

    </script>

@endsection

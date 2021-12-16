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
                <button type="button" class="btn btn-outline-primary" data-toggle="modal" data-target=".code-memo">Code
                    dictionary</button>

                {{-- <button type="button" onclick="highlightText({{ $interview->id }});"
                    class="btn btn-outline-primary">Refresh
                    quotes</button> --}}

            </div>
        </div>
    </div>


    <!-- Large modal -->
    <div class="modal fade code-memo" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <table id="example" class="table table-striped table-bordered dt-responsive nowrap" style="width:100%">
                    <thead>
                        <tr>
                            <th>Code name</th>
                            <th>Memoing</th>
                            <th>User Coder</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($codememo as $cm)
                            <tr>
                                <td>{{ $cm->description }}</td>
                                <td>{{ $cm->memo }}</td>
                                <td>{{ $cm->user->name }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div style="margin: 0 auto;height: 60px;width: 95%;">
        <input id="showSelected" style="width: 15%;" class="btn btn-dark float-right" type="button" value="Get quote" />
    </div>
    <div style="width: 95%; margin: auto;">
        <div class="row">
            <div class="col-md-4">
                {{-- <div class="child-sections">
                    <h1 class=".sub-titulos unselectable">Codes</h1>
                </div> --}}
                <div id="accordion">
                    <div class="card">
                        <div class="card-header" id="headingOne">
                            <h5 class="mb-0">
                                <button class="btn btn-link" data-toggle="collapse" data-target="#collapseOne"
                                    aria-expanded="true" aria-controls="collapseOne">
                                    Create a new code
                                </button>
                            </h5>
                        </div>

                        <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordion">
                            <div class="card-body">
                                <form id="codeForm">
                                    @csrf
                                    <input type="hidden" name="interview_id" value="{{ $interview->id }}">
                                    <div class="form-group">
                                        <label class="unselectable" for="exampleFormControlInput1">Name of code</label>
                                        <input type="text" name="code_name" class="form-control code_name"
                                            id="exampleFormControlInput1" placeholder="Succcinct Code">
                                    </div>
                                    <div class="form-group">
                                        <label class="unselectable" for="exampleFormControlSelect1">Color</label>
                                        <input type="color" id="color" class="btn btn-secondary" style="width: 5%">
                                        <input type="text" name="code_color" class="form-control code_color"
                                            id="choosen-color" placeholder="#0000FF">
                                    </div>
                                    <div class="form-group">
                                        <label class="unselectable" for="exampleFormControlTextarea1">Quote</label>
                                        <textarea class="form-control code_quote" name="code_quote"
                                            placeholder="This refactoring make a code more succinct and more readably..."
                                            id="quoteText" rows="3"></textarea>
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
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header" id="headingTwo">
                            <h5 class="mb-0">
                                <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseTwo"
                                    aria-expanded="false" aria-controls="collapseTwo"
                                    onclick="linkCodeToQuote({{ $interview->id }})">
                                    Use an existing code
                                </button>
                            </h5>
                        </div>
                        <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordion">
                            <div class="card-body">
                                <form id="codeForm2">
                                    @csrf
                                    <input type="hidden" name="interview_id" value="{{ $interview->id }}">

                                    <div class="form-group">
                                        <label for="exampleFormControlSelect2">Codes</label>
                                        <select name="code2_id" multiple class="chosen-select form-control"
                                            id="codeOptions">
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label class="unselectable" for="exampleFormControlTextarea1">Quote</label>
                                        <textarea class="form-control" name="code2_quote"
                                            placeholder="This refactoring make a code more succinct and more readably..."
                                            id="quoteText2" rows="3"></textarea>
                                    </div>

                                    <button type="submit" class="btn btn-primary mb-2">Link code to quote</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
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
                    <tr id="sid{{ $code->id }}">
                        <td scope="row" style="background-color: {{ $code->color }}; color: white;">{{ $code->id }}
                        </td>
                        <td>{{ $code->description }}</td>
                        <td>{{ \Illuminate\Support\Str::limit($code->memo, 50, $end = '...') }}</td>
                        <td>{{ $code->color }}</td>
                        <td>
                            @foreach ($code->quotes as $quote)
                                @if ($loop->last)
                                    <a onclick="removeCodeQuote({{ $code->id }},'{{ $code->description }}', '{{ $code->user->name }}', {{ $quote->id }},'{{ $quote->description }}')"
                                        data-toggle="modal" data-target="#exampleModalCenter">
                                        {{ $quote->description }}
                                    </a>
                                @else
                                    <a onclick="removeCodeQuote({{ $code->id }},'{{ $code->description }}', '{{ $code->user->name }}', {{ $quote->id }},'{{ $quote->description }}')"
                                        data-toggle="modal" data-target="#exampleModalCenter">
                                        {{ $quote->description }}
                                    </a>
                                    <hr>
                                @endif
                            @endforeach
                        </td>
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

    <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalCenterTitle">Modal title</h5>
                </div>
                <form id="RemoveMark">
                    @csrf
                    <div id="body-text-remove-mark" class="modal-body">

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-danger">Remove this mark</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @component('app.layouts._partials.js-import')
    @endcomponent

    <script type="text/javascript" src="{{ asset('js/chosen.jquery.js') }}"></script>

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
                    },
                    error: function(data) {
                        console.log(data);
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

                    $.get('/code-highlighter/' + value.highlighter, function(users) {
                        if (users.length > 0) {
                            var repstr = "<span title=' Code: " + value.code_name + " - " + users[0]
                                .name +
                                "' style='background:white;padding:1px;border:" + value.color +
                                " solid 1px;border-left: 15px solid " + value.color +
                                ";font-weight: bold;'>" +
                                searchword + "</span>";
                        } else {
                            var repstr = "<span title=' Code: " + value.code_name + " - " + value
                                .name +
                                "' style='background:white;padding:1px;border:" + value.color +
                                " solid 1px;border-left: 15px solid " + value.color +
                                ";font-weight: bold;'>" +
                                searchword + "</span>";
                        }
                        if (searchword != "") {
                            $('#interview-text').each(function() {
                                $(this).html($(this).html().replace(searchword, repstr));
                            })
                        }
                    });
                });
            });
        }

        function linkCodeToQuote(id) {
            var key = parseInt(id);
            $.get('/options-code/' + key, function(codes) {
                document.getElementById("codeOptions").options.length = 0;
                timeFunction();
                // $("#codeOptions").empty();
                if (codes) {
                    $.each(codes, function(key, value) {
                        $('#codeOptions').append($("<option/>", {
                            value: key,
                            text: value
                        }));
                    });
                    $(".chosen-select").chosen()
                }
            });
        }

        function removeCodeQuote(id, code_name, user, quote, quote_text) {
            document.getElementById("exampleModalCenterTitle").innerHTML = code_name;
            document.getElementById("body-text-remove-mark").innerHTML = quote_text;
            $('#RemoveMark')[0].reset();
            $("#code_id").remove();
            $("#quote_id").remove();
            $("#RemoveMark").append("<input type='hidden' id='code_id' name='code_id' value=" + id + " >");
            $("#RemoveMark").append("<input type='hidden' id='quote_id' name='quote_id' value=" + quote + " >");
        }

        $('#RemoveMark').submit(function(e) {
            e.preventDefault();
            var code_id = $("input[name=code_id]").val();
            var _token = $("input[name=_token]").val();
            var quote_id = $("input[name=quote_id]").val();
            if (confirm("Do you really want to remove the link of this code and quote?")) {
                console.log(quote_id, code_id, _token);
                $.ajax({
                    url: "{{ route('code.quote.remove') }}",
                    type: "POST",
                    data: {
                        quote_id: quote_id,
                        code_id: code_id,
                        _token: _token,
                    },
                    success: function(response) {
                        console.log(response);
                        $("#exampleModalCenter").modal("toggle");
                        $('#RemoveMark')[0].reset();
                        highlightText({{ $interview->id }});
                        $('#codes-table').load(document.URL + ' #codes-table');
                    },
                    error: function(data) {
                        console.log(data);
                        var errors = data.responseText;
                        var jsonResponse = JSON.parse(errors);
                        $.each(jsonResponse.errors, function(key, value) {
                            alert(key + ": " + value);
                        });
                    }
                })
            }
        })

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

        $('#codeForm2').submit(function(e) {
            e.preventDefault();
            var interview_id = $("input[name=interview_id]").val();
            var code_id = $("select[name=code2_id]").val();
            var quote = $("textarea[name=code2_quote]").val();
            var _token = $("input[name=_token]").val();
            // console.log(interview_id, name, color, memo, _token, quote);
            $.ajax({
                url: "{{ route('code.store.selected') }}",
                type: "POST",
                data: {
                    interview_id: interview_id,
                    code_id: code_id,
                    _token: _token,
                    code_quote: quote
                },
                success: function(response) {
                    console.log(response);
                    $('#codeForm')[0].reset();
                    $('#codeForm2')[0].reset();
                    $('#codes-table').load(document.URL + ' #codes-table');
                    $('.search-choice').remove();
                    highlightText(interview_id);
                    linkCodeToQuote(interview_id);
                    timeFunction();
                },
                error: function(data) {
                    console.log(data);
                    var errors = data.responseText;
                    var jsonResponse = JSON.parse(errors);
                    $.each(jsonResponse.errors, function(key, value) {
                        $(".code2_" + key).after(
                            "<div class='alert alert-danger' id='alert_" +
                            key + "' role='alert'>" + value + "</div>");
                        setTimeout(function() {
                            $('#alert_' + key).remove();
                        }, 4000);
                    });
                }
            })
        })

        function timeFunction() {
            setTimeout(function(){
                $('.result-selected').addClass('test');
                $('.test').addClass('active-result').removeClass('result-selected').removeClass('test');
            }, 9000);
        }

        $('#codeForm').submit(function(e) {
            e.preventDefault();
            var interview_id = $("input[name=interview_id]").val();
            var name = $("input[name=code_name]").val();
            var color = $("input[name=code_color]").val();
            var memo = $("textarea[name=code_memo]").val();
            var quote = $("textarea[name=code_quote]").val();
            quote = quote.replace(/¶/g, '');
            var _token = $("input[name=_token]").val();
            // console.log(interview_id, name, color, memo, _token, quote);
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
                    console.log(response);
                    $('#codeForm')[0].reset();
                    $('#codeForm2')[0].reset();
                    $('#codes-table').load(document.URL + ' #codes-table');
                    $('#codeOptions').empty().trigger('change');
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
            $("textarea#quoteText2").val(text);
            timeFunction();
        });

        jQuery('#color').on('change', function() {
            $("input#choosen-color").val(jQuery(this).val());
        });

        jQuery('#color2').on('change', function() {
            $("input#choosen-color2").val(jQuery(this).val());
        });

        $(document).ready(function() {
            $('#example').DataTable();
        });
    </script>

@endsection

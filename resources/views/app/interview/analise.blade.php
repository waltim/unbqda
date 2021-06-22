@extends('app.layouts.basico')

@section('titulo', $titulo)

@section('conteudo')

    <div class="conteudo-pagina">
        <div class="titulo-pagina">
            <h1 class="unselectable">Codes Analises</h1>
        </div>

        <div class="text-right" style="padding-right: 5%">
            <div class="btn-group" role="group" aria-label="Basic example">
                <button type="button"
                    onclick="location.href = '{{ route('project.show', ['project' => $interview->project_id]) }}';"
                    class="btn btn-outline-primary">List Interviews</button>
            </div>
        </div>
    </div>

    <div class="child-sections text-center">
        <h1 class=".sub-titulos">Codes</h1>
    </div>
    <div id="codes-table" style="width: 90%; margin-left: auto; margin-right: auto;">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Code name</th>
                    <th scope="col">Memo</th>
                    {{-- <th scope="col">Color</th> --}}
                    <th scope="col">Quote</th>
                    <th scope="col">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($codes as $code)
                    <tr id="sid{{ $code->id }}">
                        <td scope="row" style="background-color: {{ $code->color }}; color: white;">{{ $code->id }}
                        </td>
                        <td>{{ $code->description }}</td>
                        <td>{{ \Illuminate\Support\Str::limit($code->memo, 50, $end = '...') }}</td>
                        <td>
                            @foreach ($code->quotes as $quote)
                                @if ($loop->last)
                                    {{ $quote->description }}
                                @else
                                    {{ $quote->description }}
                                    <hr>
                                @endif
                            @endforeach
                        </td>
                        <td class="btn-group" role="group" aria-label="Basic example" style="padding-top: 0px!important">
                            @php
                                $analises = \DB::table('codes')
                                    ->join('agreements', 'agreements.code_id', 'codes.id')
                                    ->where('agreements.user_id', '=', auth()->id())
                                    ->where('agreements.code_id', '=', $code->id)
                                    ->where('agreements.deleted_at', null)
                                    ->get();

                                $observations = \DB::table('observations')
                                    ->where('observations.code_id', '=', $code->id)
                                    ->where('observations.deleted_at', null)
                                    ->get();
                            @endphp
                            @if ($analises->count() > 0)
                                @switch($analises[0]->scale)
                                    @case(1)
                                        <button type="button" onclick="deleteAnalise({{ $analises[0]->id }})"
                                            class="btn btn-outline-danger">Strongly agree</button>
                                    @break

                                    @case(2)
                                        <button type="button" onclick="deleteAnalise({{ $analises[0]->id }})"
                                            class="btn btn-outline-danger">Agree</button>
                                    @break

                                    @case(3)
                                        <button type="button" onclick="deleteAnalise({{ $analises[0]->id }})"
                                            class="btn btn-outline-danger">Neutral</button>
                                    @break

                                    @case(4)
                                        <button type="button" onclick="deleteAnalise({{ $analises[0]->id }})"
                                            class="btn btn-outline-danger">Disagree</button>
                                    @break

                                    @case(5)
                                        <button type="button" onclick="deleteAnalise({{ $analises[0]->id }})"
                                            class="btn btn-outline-danger">Strongly disagree</button>
                                    @break

                                    @default
                                        <button type="button" onclick="deleteAnalise({{ $analises[0]->id }})"
                                            class="btn btn-outline-danger">Remove analise</button>
                                @endswitch
                            @else
                                <button type="button" data-toggle="modal" data-target="#exampleModal"
                                    onclick="codeAnalise({{ $code->id }},'{{ $code->description }}','{{ $code->memo }}')"
                                    class="btn btn-outline-primary">Make analise</button>
                            @endif
                            @if ($observations->count() > 0)
                                <button type="button"
                                onclick="location.href = '{{ route('interview.observation', ['code' => $code->id]) }}'"
                                    class="btn btn-outline-info">Show observations</button>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        {{ $codes->withQueryString()->links() }}
        {{ $codes->total() > 0 ? $codes->total() . ' - registro(s) encontrado(s).' : 'nenhum registro encontrado.' }}
    </div>

    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="code-name">Modal title</h5>
                </div>
                <div class="modal-body">
                    <form id="analiseForm">
                        @csrf
                        <div id="code-id" class="form-group">
                            <p id="quote-text" style="color: black;"></p>
                        </div>
                        <div class="form-group">
                            <label for="exampleFormControlSelect1">Select a scale</label>
                            <select name="scale" class="form-control" id="code_scale" required>
                                <option value=""> Select one option </option>
                                <option value="1">Strongly agree</option>
                                <option value="2">Agree</option>
                                <option value="3">Neutral</option>
                                <option value="4">Disagree</option>
                                <option value="5">Strongly disagree</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="unselectable" for="exampleFormControlTextarea1">Observation</label>
                            <textarea class="form-control" name="observation"
                                placeholder="This code needs small changes to improve your understanding..."
                                id="observation-text" rows="3"></textarea>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save analise</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @component('app.layouts._partials.js-import')
    @endcomponent

    <script>
        function deleteAnalise(id) {

            if (confirm("Do you really want to delete this analise?")) {
                $.ajax({
                    url: '/analise-delete/' + id,
                    type: 'DELETE',
                    data: {
                        _token: $("input[name=_token]").val()
                    },
                    success: function(response) {
                        $('#codes-table').load(document.URL + ' #codes-table');
                    },
                    error: function(data) {
                        console.log(data);
                    }
                })
            }
        }

        function codeAnalise(id, name, memo) {
            var key = parseInt(id);
            document.getElementById("code-name").innerHTML = name;
            document.getElementById("quote-text").innerHTML = "<b>Memoing:</b> " + memo;
            $("#code_id").remove();
            var new_input = "<input type='hidden' id='code_id' name='code_id' value='" + id + "'>";
            $('#analiseForm').append(new_input);
            $("#exampleModal").modal("toggle");
        }

        $('#analiseForm').submit(function(e) {
            e.preventDefault();
            var code_id = $("#code_id").val();
            var scale = $("select[name=scale]").val();
            var observation = $("textarea[name=observation]").val();
            var _token = $("input[name=_token]").val();
            var user_id = {{ auth()->id() }};
            console.log(observation, code_id, scale, user_id);
            $.ajax({
                url: "{{ route('code.observation') }}",
                type: "POST",
                data: {
                    code_id: code_id,
                    scale: scale,
                    _token: _token,
                    user_id: user_id,
                    observation: observation
                },
                success: function(response) {
                    $("#exampleModal").modal("toggle");
                    $('#analiseForm')[0].reset();
                    $('#codes-table').load(document.URL + ' #codes-table');
                },
                error: function(data) {
                    console.log(data);
                    var errors = data.responseText;
                    var jsonResponse = JSON.parse(errors);
                    $.each(jsonResponse.errors, function(key, value) {
                        $('#code_' + key).after(
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

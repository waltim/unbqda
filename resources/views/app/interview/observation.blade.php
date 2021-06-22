@extends('app.layouts.basico')

@section('titulo', $titulo)

@section('conteudo')

    <div class="conteudo-pagina">
        <div class="titulo-pagina">
            <h1 class="unselectable">Observations</h1>
        </div>

        <div class="text-right" style="padding-right: 5%">
            <div class="btn-group" role="group" aria-label="Basic example">
                <button type="button"
                    onclick="location.href = '{{ route('interview.analise', ['interview' => $interview]) }}';"
                    class="btn btn-outline-success">Interview analise</button>
                <button type="button" role="group" class="btn-group btn-outline-primary" data-toggle="modal"
                    data-target="#exampleModal" onclick="createObs({{ $code->id }},'{{ $code->description }}','{{ $code->memo }}')">
                    New observation
                </button>
            </div>
        </div>
    </div>

    <div class="child-sections text-center">
        <h1 class=".sub-titulos">Code: {{ $code->description }} </h1>
        <h3>Observations</h3>
    </div>
    <div id="observations-table" style="width: 90%; margin-left: auto; margin-right: auto;">
        @foreach ($observations as $observation)
            <div class="card" id="observation-{{ $observation->id }}" style="margin-bottom: 3%;">
                <div class="card-header">
                    {{ $observation->name }} - {{ $observation->email }}
                </div>
                <div class="card-body">
                    <h5 class="card-title">{{ $observation->created_at->format('d/m/Y H:i:s') }}</h5>
                    <p class="card-text" style="color: black!important;">{{ $observation->description }}</p>
                    {{-- @if ($observation->userId == auth()->id())
                        <button type="button" onclick="deleteObservation({{ $observation->id }})"
                            class="btn btn-danger float-right col-md-1">Remove</button>
                    @endif --}}
                </div>
            </div>
        @endforeach
        {{-- {{ $observations->withQueryString()->links() }}
        {{ $observations->total() > 0 ? $observations->total() . ' - registro(s) encontrado(s).' : 'nenhum registro encontrado.' }} --}}
    </div>

    <!-- Button trigger modal -->

    <!-- Modal -->

    <!-- Modal -->
    <div class="modal fade" id="obsModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="code-name">Modal title</h5>
                </div>
                <div class="modal-body">
                    <form id="obsForm">
                        @csrf
                        <div id="code-id" class="form-group">
                            <p id="quote-text" style="color: black;"></p>
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
        function createObs(id, name, memo) {
            var key = parseInt(id);
            document.getElementById("code-name").innerHTML = name;
            document.getElementById("quote-text").innerHTML = "<b>Memoing:</b> " + memo;
            $("#code_id").remove();
            var new_input = "<input type='hidden' id='code_id' name='code_id' value='" + id + "'>";
            $('#obsForm').append(new_input);
            $("#obsModal").modal("toggle");
        }

        $('#obsForm').submit(function(e) {
            e.preventDefault();
            var code_id = $("#code_id").val();
            var observation = $("textarea[name=observation]").val();
            var _token = $("input[name=_token]").val();
            var user_id = {{ auth()->id() }};
            console.log(observation, code_id, _token, user_id);
            $.ajax({
                url: "{{ route('code.observation') }}",
                type: "POST",
                data: {
                    code_id: code_id,
                    _token: _token,
                    user_id: user_id,
                    observation: observation
                },
                success: function(response) {
                    $("#obsModal").modal("toggle");
                    $('#obsForm')[0].reset();
                    $('#observations-table').load(document.URL + ' #observations-table');
                },
                error: function(data) {
                    console.log(data);
                }
            })
        })
    </script>

@endsection

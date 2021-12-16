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
                    data-target="#exampleModal"
                    onclick="createObs({{ $code->id }},'{{ $code->description }}','{{ $code->memo }}')">
                    New observation
                </button>
                <button type="button" role="group" class="btn-group btn-outline-success" data-toggle="modal"
                    data-target="#UpdateCode" onclick="updateCode({{ $code->id }})">
                    Update code
                </button>
            </div>
        </div>
    </div>
    <div id="code-observation-data">
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
    </div>

    <!-- Button trigger modal -->

    <!-- Modal -->

    <div class="modal fade" id="UpdateCode" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalCenterTitle">Update code</h5>
                </div>
                <form id="codeForm">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="project_id" value="{{ $code->project_id }}">
                    <input type="hidden" name="code_id" value="{{ $code->id }}">
                    <div class="form-group">
                        <label class="unselectable" for="exampleFormControlInput1">Name of code</label>
                        <input type="text" name="code_name" class="form-control code_name" id="code_name1"
                            placeholder="Succcinct Code" value="{{ $code->description }}">
                    </div>
                    <div class="form-group">
                        <label class="unselectable" for="exampleFormControlSelect1">Color</label>
                        <input type="color" id="code_color1" class="btn btn-secondary" style="width: 5%">
                        <input type="text" name="code_color" value="{{ $code->color }}" class="form-control code_color"
                            id="choosen-color" placeholder="#0000FF">
                    </div>
                    <div class="form-group">
                        <label class="unselectable" for="exampleFormControlTextarea1">Quotes</label>
                        <br>
                        @foreach ($code->quotes as $quote)
                            @if ($quote->interview_id == $interview->id)
                                @if ($loop->last)
                                    {{ $quote->description }}
                                @else
                                    {{ $quote->description }}
                                    <hr>
                                @endif
                            @endif
                        @endforeach
                    </div>
                    <div class="form-group">
                        <label class="unselectable" for="exampleFormControlTextarea1">Memo</label>
                        <textarea class="form-control code_memo" name="code_memo"
                            placeholder="This refactoring make a code more succinct and more readably..." id="code_memo1"
                            rows="3">{{ $code->memo }}</textarea>
                    </div>
                    <button type="submit" class="btn btn-primary mb-2">Update code</button>
                </form>
            </div>
        </div>
    </div>

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
                        <input type="hidden" name="interview_id" value="{{ $interview }}">
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
            var interview_id = $("input[name=interview_id]").val();
            var user_id = {{ auth()->id() }};
            console.log(observation, code_id, _token, user_id);
            $.ajax({
                url: "{{ route('code.observation') }}",
                type: "POST",
                data: {
                    code_id: code_id,
                    _token: _token,
                    user_id: user_id,
                    observation: observation,
                    interivew_id: interivew_id
                },
                success: function(response) {
                    $("#obsModal").modal("toggle");
                    $('#obsForm')[0].reset();
                    $('#code-observation-data').load(document.URL + ' #code-observation-data');
                },
                error: function(data) {
                    console.log(data);
                }
            })
        })

        function updateCode(id) {
            var key = parseInt(id);
            console.log(key);
            $("#UpdateCode").modal("toggle");
        }

        $('#codeForm').submit(function(e) {
            e.preventDefault();
            var id = $("input[name=code_id]").val();
            var pid = $("input[name=project_id]").val();
            var name = $("input[name=code_name]").val();
            var color = $("input[name=code_color]").val();
            var memo = $("textarea[name=code_memo]").val();
            var _token = $("input[name=_token]").val();
            var _method = $("input[name=_method]").val();
            // console.log(pid, name, color, memo, _token, _method);
            var element = this;
            $.ajax({
                url: "{{ route('code.update') }}",
                type: "POST",
                data: {
                    id: id,
                    project_id: pid,
                    description: name,
                    color: color,
                    memo: memo,
                    _token: _token,
                    _method: _method
                },
                success: function(response) {
                    // console.log(response.description);

                    $('#codeForm')[0].reset();
                    $('#code-observation-data').load(document.URL + ' #code-observation-data');
                    setNewDatas(response.description, response.memo, response.color);
                    $("#UpdateCode").modal("toggle");
                },
                error: function(data) {
                    console.log(data);
                }
            })
        })

        function setNewDatas(description, memo, color) {
            $('input[name=code_name]').val(description);
            $('input[name=code_memo]').val(memo);
            $('input[name=code_color]').val(color);
        }

        jQuery('#color').on('change', function() {
            $("input#choosen-color").val(jQuery(this).val());
        });
    </script>

@endsection

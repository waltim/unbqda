@extends('app.layouts.basico')

@section('titulo', $titulo)

@section('conteudo')

    <div class="conteudo-pagina">
        <div class="titulo-pagina">
            <h1 class="unselectable">Interview comments</h1>
        </div>

        <div class="text-right" style="padding-right: 5%">
            <div class="btn-group" role="group" aria-label="Basic example">
                <button type="button"
                    onclick="location.href = '{{ route('interview.analise', ['interview' => $interview]) }}';"
                    class="btn btn-outline-success">Interview analise</button>
                <button type="button" role="group" class="btn-group btn-outline-primary" data-toggle="modal"
                    data-target="#commentModal">
                    New comment for interview
                </button>
            </div>
        </div>
    </div>
    <div id="code-observation-data">
        <div class="child-sections text-center">
            <h1 class=".sub-titulos">Interview: {{ $interview->name }} </h1>
            <h3>Comments</h3>
        </div>
        <div id="comments-table" style="width: 90%; margin-left: auto; margin-right: auto;">
            @foreach ($comments as $comment)
                <div class="card" id="observation-{{ $comment->id }}" style="margin-bottom: 3%;">
                    <div class="card-header">
                        {{ $comment->name }} - {{ $comment->email }}
                    </div>
                    <div class="card-body">
                        <h5 class="card-title">{{ $comment->created_at->format('d/m/Y H:i:s') }}</h5>
                        <p class="card-text" style="color: black!important;">{{ $comment->description }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <div class="modal fade" id="commentModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="comment-name">New comment</h5>
                </div>
                <div class="modal-body">
                    <form id="commentForm">
                        @csrf
                        <input type="hidden" name="comment_user" value="{{ auth()->id() }}">
                        <input type="hidden" name="comment_interview" value="{{ $interview->id }}">
                        <div class="form-group">
                            <label class="unselectable" for="exampleFormControlTextarea1">Comment</label>
                            <textarea class="form-control" name="comment"
                                placeholder="This code needs small changes to improve your understanding..."
                                id="comment-text" rows="3"></textarea>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Send comment</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Button trigger modal -->

    <!-- Modal -->

    @component('app.layouts._partials.js-import')
    @endcomponent

    <script>
    $('#commentForm').submit(function(e) {
            e.preventDefault();
            var interview_id = $("input[name=comment_interview]").val();
            var comment = $("textarea[name=comment]").val();
            var _token = $("input[name=_token]").val();
            var user_id = {{ auth()->id() }};
            console.log(comment, interview_id, _token, user_id);
            $.ajax({
                url: "{{ route('comment.interview') }}",
                type: "POST",
                data: {
                    interview_id: interview_id,
                    description: comment,
                    _token: _token,
                    user_id: user_id
                },
                success: function(response) {
                    $("#commentModal").modal("toggle");
                    $('#commentForm')[0].reset();
                    $('#comments-table').load(document.URL + ' #comments-table');
                },
                error: function(data) {
                    console.log(data);
                }
            })
        })
    </script>

@endsection

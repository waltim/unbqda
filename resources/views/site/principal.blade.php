@extends('site.layouts.basico')
@section('titulo', $titulo)
@section('conteudo')
    <div class="conteudo-destaque">

        <div class="esquerda">
            <div class="informacoes">
                <h1>Sistema de análise qualitativa</h1>
                <p>Software para analisar suas entrevistas, realizar as etapas de codificação de forma colaborativa e fácil.
                <p>
                <div class="chamada">
                    <img src="{{ asset('img/check.png') }}">
                    <span class="texto-branco">Codificações e categorias</span>
                </div>
                <div class="chamada">
                    <img src="{{ asset('img/check.png') }}">
                    <span class="texto-branco">Geração de gráficos e relatórios</span>
                </div>
            </div>

            <div class="video">
                <img src="{{ asset('img/player_video.jpg') }}">
            </div>
        </div>

        <div class="direita">
            <div class="contato">
                <h1>Login</h1>
                <p>Conecte-se para iniciar suas análises.</p>
                    @component('site.layouts._components.form_contato', ['borda' => 'borda-branca'])
                    @endcomponent
            </div>
        </div>
    </div>
@endsection

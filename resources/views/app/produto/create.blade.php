@extends('app.layouts.basico')


@section('titulo', 'Produto')

@section('conteudo')

    <div class="conteudo-pagina">
        <div class="titulo-pagina-2">
            <p>Cadastrar novo produto</p>
        </div>

        <div class="menu">
            <ul>
                <li><a href="{{ route('produto.create') }}">Novo</a></li>
                <li><a href="{{ route('produto.index') }}">Consulta</a></li>
            </ul>
        </div>
        @if ($msg != '')
            <h3>{{ $msg }}</h3>
        @endif
        <div class="informacao-pagina">
            <div style="width: 30%; margin-left: auto; margin-right: auto;">
                <form action="{{ route('produto.store') }}" method="post">
                    @csrf
                    <input type="text" value="{{ old('nome') ? old('nome') : '' }}" name="nome"
                        placeholder="nome do produto" class="borda-preta">
                    <br>
                    {{ $errors->has('nome') ? $errors->first('nome') : '' }}
                    <br>
                    <input type="text" name="descricao" value="{{ old('descricao') ? old('descricao') : '' }}"
                        placeholder="descricao do produto" class="borda-preta">
                    <br>
                    {{ $errors->has('descricao') ? $errors->first('descricao') : '' }}
                    <br>
                    <input type="text" name="peso" value="{{ old('peso') ? old('peso') : '' }}"
                        placeholder="Peso do produto" class="borda-preta">
                    <br>
                    {{ $errors->has('peso') ? $errors->first('peso') : '' }}
                    <br>
                    <select name="unidade_id" class="borda-preta">
                        <option>Selecione uma unidade</option>
                        @foreach ($unidades as $unidade)
                            <option value="{{ $unidade->id }}"
                                {{ old('unidade_id') == $unidade->id ? 'selected' : '' }}>{{ $unidade->sigla }}
                            </option>
                        @endforeach
                    </select>
                    <br>
                    {{ $errors->has('unidade_id') ? $errors->first('unidade_id') : '' }}
                    <br>
                    <button type="submit" class="borda-preta">Cadastrar</button>
                </form>
            </div>
        </div>
    </div>

@endsection

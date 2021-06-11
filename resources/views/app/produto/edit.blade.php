@extends('app.layouts.basico')


@section('titulo', 'Produto')

@section('conteudo')

    <div class="conteudo-pagina">
        <div class="titulo-pagina-2">
            <p>Atualizar produto</p>
        </div>

        <div class="menu">
            <ul>
                <li><a href="{{ route('produto.create') }}">Novo</a></li>
                <li><a href="{{ route('produto.index') }}">Consulta</a></li>
            </ul>
        </div>

        <div class="informacao-pagina">
            <div style="width: 30%; margin-left: auto; margin-right: auto;">
                <form action="{{ route('produto.update', ['produto' => $produto->id]) }}" method="post">
                    @csrf
                    @method('PUT')
                    {{-- <input type="hidden" value="{{ $produto->id }}"> --}}
                    <input type="text" value="{{ $produto->nome ?? old('nome') }}" name="nome"
                        placeholder="nome do produto" class="borda-preta">
                    <br>
                    {{ $errors->has('nome') ? $errors->first('nome') : '' }}
                    <br>
                    <input type="text" name="descricao" value="{{ $produto->descricao ?? old('descricao') }}"
                        placeholder="descricao do produto" class="borda-preta">
                    <br>
                    {{ $errors->has('descricao') ? $errors->first('descricao') : '' }}
                    <br>
                    <input type="text" name="peso" value="{{ $produto->peso ?? old('peso') }}"
                        placeholder="Peso do produto" class="borda-preta">
                    <br>
                    {{ $errors->has('peso') ? $errors->first('peso') : '' }}
                    <br>
                    <select name="unidade_id" class="borda-preta">
                        <option>Selecione uma unidade</option>
                        @foreach ($unidades as $unidade)
                            <option value="{{ $unidade->id }}"
                                {{ ($produto->unidade_id ?? old('unidade_id')) == $unidade->id ? 'selected' : '' }}>{{ $unidade->sigla }}
                            </option>
                        @endforeach
                    </select>
                    <br>
                    {{ $errors->has('unidade_id') ? $errors->first('unidade_id') : '' }}
                    <br>
                    <button type="submit" class="borda-preta">Atualizar</button>
                </form>
            </div>
        </div>
    </div>

@endsection

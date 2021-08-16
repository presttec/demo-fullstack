@extends('layouts.app')

@section('title', __('livro.create'))

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">{{ __('livro.create') }}</div>
            <form method="POST" action="{{ route('livros.store') }}" accept-charset="UTF-8">
                {{ csrf_field() }}
                <div class="card-body">
                    <div class="form-group">
                        <label for="titulo" class="form-label">{{ __('livro.titulo') }} <span class="form-required">*</span></label>
                        <input id="titulo" type="text" class="form-control{{ $errors->has('titulo') ? ' is-invalid' : '' }}" name="titulo" value="{{ old('titulo') }}" required>
                        {!! $errors->first('titulo', '<span class="invalid-feedback" role="alert">:message</span>') !!}
                    </div>
                    <div class="form-group">
                        <label for="ano_lancamento" class="form-label">{{ __('livro.ano_lancamento') }} <span class="form-required">*</span></label>
                        <input id="ano_lancamento" type="text" class="form-control{{ $errors->has('ano_lancamento') ? ' is-invalid' : '' }}" name="ano_lancamento" value="{{ old('ano_lancamento') }}" required>
                        {!! $errors->first('ano_lancamento', '<span class="invalid-feedback" role="alert">:message</span>') !!}
                    </div>
                    <div class="form-group">
                        <label for="resumo" class="form-label">{{ __('livro.resumo') }}</label>
                        <textarea id="resumo" class="form-control{{ $errors->has('resumo') ? ' is-invalid' : '' }}" name="resumo" rows="4">{{ old('resumo') }}</textarea>
                        {!! $errors->first('resumo', '<span class="invalid-feedback" role="alert">:message</span>') !!}
                    </div>
                    <div class="form-group">
                        <label for="autor_id" class="form-label">{{ __('livro.autor_id') }} <span class="form-required">*</span></label>
						<select id="autor_id" class="form-control{{ $errors->has('autor_id') ? ' is-invalid' : '' }}" name="autor_id" value="{{ old('autor_id') }}" required>
							<option value="">Selecine</option>
							@foreach ($lista_autor as $reg)
							<option value="{{ $reg->id}}">{{$reg->nome}}</option>
							@endforeach
						</select>                        
                        {!! $errors->first('autor_id', '<span class="invalid-feedback" role="alert">:message</span>') !!}
                    </div>					
                    <div class="form-group">
                        <label for="editora_id" class="form-label">{{ __('livro.editora_id') }} <span class="form-required">*</span></label>
						<select id="editora_id" class="form-control{{ $errors->has('editora_id') ? ' is-invalid' : '' }}" name="editora_id" value="{{ old('editora_id') }}" required>
							<option value="">Selecine</option>
							@foreach ($lista_editora as $reg)
							<option value="{{ $reg->id}}">{{$reg->nome}}</option>
							@endforeach
						</select>                        
                        {!! $errors->first('editora_id', '<span class="invalid-feedback" role="alert">:message</span>') !!}
                    </div>
                    <div class="form-group">
                        <label for="genero_id" class="form-label">{{ __('livro.genero_id') }} <span class="form-required">*</span></label>
						<select id="genero_id" class="form-control{{ $errors->has('genero_id') ? ' is-invalid' : '' }}" name="genero_id" value="{{ old('genero_id') }}" required>
							<option value="">Selecine</option>
							@foreach ($lista_genero as $reg)
							<option value="{{ $reg->id}}">{{$reg->nome}}</option>
							@endforeach
						</select>                        
                        {!! $errors->first('genero_id', '<span class="invalid-feedback" role="alert">:message</span>') !!}
                    </div>
					
                </div>
                <div class="card-footer">
                    <input type="submit" value="{{ __('livro.create') }}" class="btn btn-success">
                    <a href="{{ route('livros.index') }}" class="btn btn-link">{{ __('app.cancel') }}</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

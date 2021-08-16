@extends('layouts.app')

@section('title', __('autor.create'))

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">{{ __('autor.create') }}</div>
            <form method="POST" action="{{ route('autores.store') }}" accept-charset="UTF-8">
                {{ csrf_field() }}
                <div class="card-body">
                    <div class="form-group">
                        <label for="nome" class="form-label">{{ __('autor.nome') }} <span class="form-required">*</span></label>
                        <input id="nome" type="text" class="form-control{{ $errors->has('nome') ? ' is-invalid' : '' }}" name="nome" value="{{ old('nome') }}" required>
                        {!! $errors->first('nome', '<span class="invalid-feedback" role="alert">:message</span>') !!}
                    </div>
                    <div class="form-group">
                        <label for="biografia" class="form-label">{{ __('autor.biografia') }}</label>
                        <textarea id="biografia" class="form-control{{ $errors->has('biografia') ? ' is-invalid' : '' }}" name="biografia" rows="4">{{ old('biografia') }}</textarea>
                        {!! $errors->first('biografia', '<span class="invalid-feedback" role="alert">:message</span>') !!}
                    </div>
                    <div class="form-group">
                        <label for="ano_nascimento" class="form-label">{{ __('autor.ano_nascimento') }} <span class="form-required">*</span></label>
                        <input id="ano_nascimento" type="text" class="form-control{{ $errors->has('ano_nascimento') ? ' is-invalid' : '' }}" name="ano_nascimento" value="{{ old('ano_nascimento') }}" required>
                        {!! $errors->first('ano_nascimento', '<span class="invalid-feedback" role="alert">:message</span>') !!}
                    </div>
                    <div class="form-group">
                        <label for="sexo" class="form-label">{{ __('autor.sexo') }} <span class="form-required">*</span></label>
                        <select id="sexo" name="sexo" required>
							<option value="">Selecione uma opção</option>
							<option value="M">Masculino</option>
							<option value="F">Feminino</option>
						</select>
                        {!! $errors->first('sexo', '<span class="invalid-feedback" role="alert">:message</span>') !!}
                    </div>
                    <div class="form-group">
                        <label for="nacionalidade" class="form-label">{{ __('autor.nacionalidade') }} <span class="form-required">*</span></label>
                        <input id="nacionalidade" type="text" class="form-control{{ $errors->has('nacionalidade') ? ' is-invalid' : '' }}" name="nacionalidade" value="{{ old('nacionalidade') }}" required>
                        {!! $errors->first('nacionalidade', '<span class="invalid-feedback" role="alert">:message</span>') !!}
                    </div>
                </div>
                <div class="card-footer">
                    <input type="submit" value="{{ __('autor.create') }}" class="btn btn-success">
                    <a href="{{ route('autores.index') }}" class="btn btn-link">{{ __('app.cancel') }}</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

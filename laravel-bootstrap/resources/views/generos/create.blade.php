@extends('layouts.app')

@section('title', __('genero.create'))

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">{{ __('genero.create') }}</div>
            <form method="POST" action="{{ route('generos.store') }}" accept-charset="UTF-8">
                {{ csrf_field() }}
                <div class="card-body">
                    <div class="form-group">
                        <label for="nome" class="form-label">{{ __('genero.nome') }} <span class="form-required">*</span></label>
                        <input id="nome" type="text" class="form-control{{ $errors->has('nome') ? ' is-invalid' : '' }}" name="nome" value="{{ old('nome') }}" required>
                        {!! $errors->first('nome', '<span class="invalid-feedback" role="alert">:message</span>') !!}
                    </div>
                    <div class="form-group">
                        <label for="descricao" class="form-label">{{ __('genero.descricao') }}</label>
                        <textarea id="descricao" class="form-control{{ $errors->has('descricao') ? ' is-invalid' : '' }}" name="descricao" rows="4">{{ old('descricao') }}</textarea>
                        {!! $errors->first('descricao', '<span class="invalid-feedback" role="alert">:message</span>') !!}
                    </div>
                </div>
                <div class="card-footer">
                    <input type="submit" value="{{ __('genero.create') }}" class="btn btn-success">
                    <a href="{{ route('generos.index') }}" class="btn btn-link">{{ __('app.cancel') }}</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

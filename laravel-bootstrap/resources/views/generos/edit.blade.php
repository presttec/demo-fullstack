@extends('layouts.app')

@section('title', __('genero.edit'))

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        @if (request('action') == 'delete' && $genero)
        @can('delete', $genero)
            <div class="card">
                <div class="card-header">{{ __('genero.delete') }}</div>
                <div class="card-body">
                    <label class="form-label text-primary">{{ __('genero.nome') }}</label>
                    <p>{{ $genero->nome }}</p>
                    <label class="form-label text-primary">{{ __('genero.descricao') }}</label>
                    <p>{{ $genero->descricao }}</p>
                    {!! $errors->first('genero_id', '<span class="invalid-feedback" role="alert">:message</span>') !!}
                </div>
                <hr style="margin:0">
                <div class="card-body text-danger">{{ __('genero.delete_confirm') }}</div>
                <div class="card-footer">
                    <form method="POST" action="{{ route('generos.destroy', $genero) }}" accept-charset="UTF-8" onsubmit="return confirm(&quot;{{ __('app.delete_confirm') }}&quot;)" class="del-form float-right" style="display: inline;">
                        {{ csrf_field() }} {{ method_field('delete') }}
                        <input name="genero_id" type="hidden" value="{{ $genero->id }}">
                        <button type="submit" class="btn btn-danger">{{ __('app.delete_confirm_button') }}</button>
                    </form>
                    <a href="{{ route('generos.edit', $genero) }}" class="btn btn-link">{{ __('app.cancel') }}</a>
                </div>
            </div>
        @endcan
        @else
        <div class="card">
            <div class="card-header">{{ __('genero.edit') }}</div>
            <form method="POST" action="{{ route('generos.update', $genero) }}" accept-charset="UTF-8">
                {{ csrf_field() }} {{ method_field('patch') }}
                <div class="card-body">
                    <div class="form-group">
                        <label for="nome" class="form-label">{{ __('genero.nome') }} <span class="form-required">*</span></label>
                        <input id="nome" type="text" class="form-control{{ $errors->has('nome') ? ' is-invalid' : '' }}" name="nome" value="{{ old('nome', $genero->nome) }}" required>
                        {!! $errors->first('nome', '<span class="invalid-feedback" role="alert">:message</span>') !!}
                    </div>
                    <div class="form-group">
                        <label for="descricao" class="form-label">{{ __('genero.descricao') }}</label>
                        <textarea id="descricao" class="form-control{{ $errors->has('descricao') ? ' is-invalid' : '' }}" name="descricao" rows="4">{{ old('descricao', $genero->descricao) }}</textarea>
                        {!! $errors->first('descricao', '<span class="invalid-feedback" role="alert">:message</span>') !!}
                    </div>
                </div>
                <div class="card-footer">
                    <input type="submit" value="{{ __('genero.update') }}" class="btn btn-success">
                    <a href="{{ route('generos.show', $genero) }}" class="btn btn-link">{{ __('app.cancel') }}</a>
                    @can('delete', $genero)
                        <a href="{{ route('generos.edit', [$genero, 'action' => 'delete']) }}" id="del-genero-{{ $genero->id }}" class="btn btn-danger float-right">{{ __('app.delete') }}</a>
                    @endcan
                </div>
            </form>
        </div>
    </div>
</div>
@endif
@endsection

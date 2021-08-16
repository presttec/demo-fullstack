@extends('layouts.app')

@section('title', __('autor.edit'))

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        @if (request('action') == 'delete' && $autor)
        @can('delete', $autor)
            <div class="card">
                <div class="card-header">{{ __('autor.delete') }}</div>
                <div class="card-body">
                    <label class="form-label text-primary">{{ __('autor.name') }}</label>
                    <p>{{ $autor->name }}</p>
                    <label class="form-label text-primary">{{ __('autor.description') }}</label>
                    <p>{{ $autor->description }}</p>
                    {!! $errors->first('autor_id', '<span class="invalid-feedback" role="alert">:message</span>') !!}
                </div>
                <hr style="margin:0">
                <div class="card-body text-danger">{{ __('autor.delete_confirm') }}</div>
                <div class="card-footer">
                    <form method="POST" action="{{ route('autores.destroy', $autor) }}" accept-charset="UTF-8" onsubmit="return confirm(&quot;{{ __('app.delete_confirm') }}&quot;)" class="del-form float-right" style="display: inline;">
                        {{ csrf_field() }} {{ method_field('delete') }}
                        <input name="autor_id" type="hidden" value="{{ $autor->id }}">
                        <button type="submit" class="btn btn-danger">{{ __('app.delete_confirm_button') }}</button>
                    </form>
                    <a href="{{ route('autores.edit', $autor) }}" class="btn btn-link">{{ __('app.cancel') }}</a>
                </div>
            </div>
        @endcan
        @else
        <div class="card">
            <div class="card-header">{{ __('autor.edit') }}</div>
            <form method="POST" action="{{ route('autores.update', $autor) }}" accept-charset="UTF-8">
                {{ csrf_field() }} {{ method_field('patch') }}
                <div class="card-body">
                    <div class="form-group">
                        <label for="name" class="form-label">{{ __('autor.name') }} <span class="form-required">*</span></label>
                        <input id="name" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ old('name', $autor->name) }}" required>
                        {!! $errors->first('name', '<span class="invalid-feedback" role="alert">:message</span>') !!}
                    </div>
                    <div class="form-group">
                        <label for="description" class="form-label">{{ __('autor.description') }}</label>
                        <textarea id="description" class="form-control{{ $errors->has('description') ? ' is-invalid' : '' }}" name="description" rows="4">{{ old('description', $autor->description) }}</textarea>
                        {!! $errors->first('description', '<span class="invalid-feedback" role="alert">:message</span>') !!}
                    </div>
                </div>
                <div class="card-footer">
                    <input type="submit" value="{{ __('autor.update') }}" class="btn btn-success">
                    <a href="{{ route('autores.show', $autor) }}" class="btn btn-link">{{ __('app.cancel') }}</a>
                    @can('delete', $autor)
                        <a href="{{ route('autores.edit', [$autor, 'action' => 'delete']) }}" id="del-autor-{{ $autor->id }}" class="btn btn-danger float-right">{{ __('app.delete') }}</a>
                    @endcan
                </div>
            </form>
        </div>
    </div>
</div>
@endif
@endsection

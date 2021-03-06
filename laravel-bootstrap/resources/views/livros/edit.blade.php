@extends('layouts.app')

@section('title', __('livro.edit'))

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        @if (request('action') == 'delete' && $livro)
        @can('delete', $livro)
            <div class="card">
                <div class="card-header">{{ __('livro.delete') }}</div>
                <div class="card-body">
                    <label class="form-label text-primary">{{ __('livro.name') }}</label>
                    <p>{{ $livro->name }}</p>
                    <label class="form-label text-primary">{{ __('livro.description') }}</label>
                    <p>{{ $livro->description }}</p>
                    {!! $errors->first('livro_id', '<span class="invalid-feedback" role="alert">:message</span>') !!}
                </div>
                <hr style="margin:0">
                <div class="card-body text-danger">{{ __('livro.delete_confirm') }}</div>
                <div class="card-footer">
                    <form method="POST" action="{{ route('livros.destroy', $livro) }}" accept-charset="UTF-8" onsubmit="return confirm(&quot;{{ __('app.delete_confirm') }}&quot;)" class="del-form float-right" style="display: inline;">
                        {{ csrf_field() }} {{ method_field('delete') }}
                        <input name="livro_id" type="hidden" value="{{ $livro->id }}">
                        <button type="submit" class="btn btn-danger">{{ __('app.delete_confirm_button') }}</button>
                    </form>
                    <a href="{{ route('livros.edit', $livro) }}" class="btn btn-link">{{ __('app.cancel') }}</a>
                </div>
            </div>
        @endcan
        @else
        <div class="card">
            <div class="card-header">{{ __('livro.edit') }}</div>
            <form method="POST" action="{{ route('livros.update', $livro) }}" accept-charset="UTF-8">
                {{ csrf_field() }} {{ method_field('patch') }}
                <div class="card-body">
                    <div class="form-group">
                        <label for="name" class="form-label">{{ __('livro.name') }} <span class="form-required">*</span></label>
                        <input id="name" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ old('name', $livro->name) }}" required>
                        {!! $errors->first('name', '<span class="invalid-feedback" role="alert">:message</span>') !!}
                    </div>
                    <div class="form-group">
                        <label for="description" class="form-label">{{ __('livro.description') }}</label>
                        <textarea id="description" class="form-control{{ $errors->has('description') ? ' is-invalid' : '' }}" name="description" rows="4">{{ old('description', $livro->description) }}</textarea>
                        {!! $errors->first('description', '<span class="invalid-feedback" role="alert">:message</span>') !!}
                    </div>
                </div>
                <div class="card-footer">
                    <input type="submit" value="{{ __('livro.update') }}" class="btn btn-success">
                    <a href="{{ route('livros.show', $livro) }}" class="btn btn-link">{{ __('app.cancel') }}</a>
                    @can('delete', $livro)
                        <a href="{{ route('livros.edit', [$livro, 'action' => 'delete']) }}" id="del-livro-{{ $livro->id }}" class="btn btn-danger float-right">{{ __('app.delete') }}</a>
                    @endcan
                </div>
            </form>
        </div>
    </div>
</div>
@endif
@endsection

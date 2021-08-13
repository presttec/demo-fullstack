@extends('layouts.app')

@section('title', __('author.edit'))

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        @if (request('action') == 'delete' && $author)
        @can('delete', $author)
            <div class="card">
                <div class="card-header">{{ __('author.delete') }}</div>
                <div class="card-body">
                    <label class="form-label text-primary">{{ __('author.name') }}</label>
                    <p>{{ $author->name }}</p>
                    <label class="form-label text-primary">{{ __('author.description') }}</label>
                    <p>{{ $author->description }}</p>
                    {!! $errors->first('author_id', '<span class="invalid-feedback" role="alert">:message</span>') !!}
                </div>
                <hr style="margin:0">
                <div class="card-body text-danger">{{ __('author.delete_confirm') }}</div>
                <div class="card-footer">
                    <form method="POST" action="{{ route('authors.destroy', $author) }}" accept-charset="UTF-8" onsubmit="return confirm(&quot;{{ __('app.delete_confirm') }}&quot;)" class="del-form float-right" style="display: inline;">
                        {{ csrf_field() }} {{ method_field('delete') }}
                        <input name="author_id" type="hidden" value="{{ $author->id }}">
                        <button type="submit" class="btn btn-danger">{{ __('app.delete_confirm_button') }}</button>
                    </form>
                    <a href="{{ route('authors.edit', $author) }}" class="btn btn-link">{{ __('app.cancel') }}</a>
                </div>
            </div>
        @endcan
        @else
        <div class="card">
            <div class="card-header">{{ __('author.edit') }}</div>
            <form method="POST" action="{{ route('authors.update', $author) }}" accept-charset="UTF-8">
                {{ csrf_field() }} {{ method_field('patch') }}
                <div class="card-body">
                    <div class="form-group">
                        <label for="name" class="form-label">{{ __('author.name') }} <span class="form-required">*</span></label>
                        <input id="name" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ old('name', $author->name) }}" required>
                        {!! $errors->first('name', '<span class="invalid-feedback" role="alert">:message</span>') !!}
                    </div>
                    <div class="form-group">
                        <label for="description" class="form-label">{{ __('author.description') }}</label>
                        <textarea id="description" class="form-control{{ $errors->has('description') ? ' is-invalid' : '' }}" name="description" rows="4">{{ old('description', $author->description) }}</textarea>
                        {!! $errors->first('description', '<span class="invalid-feedback" role="alert">:message</span>') !!}
                    </div>
                </div>
                <div class="card-footer">
                    <input type="submit" value="{{ __('author.update') }}" class="btn btn-success">
                    <a href="{{ route('authors.show', $author) }}" class="btn btn-link">{{ __('app.cancel') }}</a>
                    @can('delete', $author)
                        <a href="{{ route('authors.edit', [$author, 'action' => 'delete']) }}" id="del-author-{{ $author->id }}" class="btn btn-danger float-right">{{ __('app.delete') }}</a>
                    @endcan
                </div>
            </form>
        </div>
    </div>
</div>
@endif
@endsection

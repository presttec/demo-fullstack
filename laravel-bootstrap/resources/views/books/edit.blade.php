@extends('layouts.app')

@section('title', __('books.edit'))

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        @if (request('action') == 'delete' && $books)
        @can('delete', $books)
            <div class="card">
                <div class="card-header">{{ __('books.delete') }}</div>
                <div class="card-body">
                    <label class="form-label text-primary">{{ __('books.name') }}</label>
                    <p>{{ $books->name }}</p>
                    <label class="form-label text-primary">{{ __('books.description') }}</label>
                    <p>{{ $books->description }}</p>
                    {!! $errors->first('books_id', '<span class="invalid-feedback" role="alert">:message</span>') !!}
                </div>
                <hr style="margin:0">
                <div class="card-body text-danger">{{ __('books.delete_confirm') }}</div>
                <div class="card-footer">
                    <form method="POST" action="{{ route('books.destroy', $books) }}" accept-charset="UTF-8" onsubmit="return confirm(&quot;{{ __('app.delete_confirm') }}&quot;)" class="del-form float-right" style="display: inline;">
                        {{ csrf_field() }} {{ method_field('delete') }}
                        <input name="books_id" type="hidden" value="{{ $books->id }}">
                        <button type="submit" class="btn btn-danger">{{ __('app.delete_confirm_button') }}</button>
                    </form>
                    <a href="{{ route('books.edit', $books) }}" class="btn btn-link">{{ __('app.cancel') }}</a>
                </div>
            </div>
        @endcan
        @else
        <div class="card">
            <div class="card-header">{{ __('books.edit') }}</div>
            <form method="POST" action="{{ route('books.update', $books) }}" accept-charset="UTF-8">
                {{ csrf_field() }} {{ method_field('patch') }}
                <div class="card-body">
                    <div class="form-group">
                        <label for="name" class="form-label">{{ __('books.name') }} <span class="form-required">*</span></label>
                        <input id="name" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ old('name', $books->name) }}" required>
                        {!! $errors->first('name', '<span class="invalid-feedback" role="alert">:message</span>') !!}
                    </div>
                    <div class="form-group">
                        <label for="description" class="form-label">{{ __('books.description') }}</label>
                        <textarea id="description" class="form-control{{ $errors->has('description') ? ' is-invalid' : '' }}" name="description" rows="4">{{ old('description', $books->description) }}</textarea>
                        {!! $errors->first('description', '<span class="invalid-feedback" role="alert">:message</span>') !!}
                    </div>
                </div>
                <div class="card-footer">
                    <input type="submit" value="{{ __('books.update') }}" class="btn btn-success">
                    <a href="{{ route('books.show', $books) }}" class="btn btn-link">{{ __('app.cancel') }}</a>
                    @can('delete', $books)
                        <a href="{{ route('books.edit', [$books, 'action' => 'delete']) }}" id="del-books-{{ $books->id }}" class="btn btn-danger float-right">{{ __('app.delete') }}</a>
                    @endcan
                </div>
            </form>
        </div>
    </div>
</div>
@endif
@endsection
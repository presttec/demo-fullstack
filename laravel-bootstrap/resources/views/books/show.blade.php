@extends('layouts.app')

@section('title', __('books.detail'))

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">{{ __('books.detail') }}</div>
            <div class="card-body">
                <table class="table table-sm">
                    <tbody>
                        <tr><td>{{ __('books.name') }}</td><td>{{ $books->name }}</td></tr>
                        <tr><td>{{ __('books.description') }}</td><td>{{ $books->description }}</td></tr>
                    </tbody>
                </table>
            </div>
            <div class="card-footer">
                @can('update', $books)
                    <a href="{{ route('books.edit', $books) }}" id="edit-books-{{ $books->id }}" class="btn btn-warning">{{ __('books.edit') }}</a>
                @endcan
                <a href="{{ route('books.index') }}" class="btn btn-link">{{ __('books.back_to_index') }}</a>
            </div>
        </div>
    </div>
</div>
@endsection

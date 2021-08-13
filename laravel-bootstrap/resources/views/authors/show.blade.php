@extends('layouts.app')

@section('title', __('author.detail'))

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">{{ __('author.detail') }}</div>
            <div class="card-body">
                <table class="table table-sm">
                    <tbody>
                        <tr><td>{{ __('author.name') }}</td><td>{{ $author->name }}</td></tr>
                        <tr><td>{{ __('author.description') }}</td><td>{{ $author->description }}</td></tr>
                    </tbody>
                </table>
            </div>
            <div class="card-footer">
                @can('update', $author)
                    <a href="{{ route('authors.edit', $author) }}" id="edit-author-{{ $author->id }}" class="btn btn-warning">{{ __('author.edit') }}</a>
                @endcan
                <a href="{{ route('authors.index') }}" class="btn btn-link">{{ __('author.back_to_index') }}</a>
            </div>
        </div>
    </div>
</div>
@endsection

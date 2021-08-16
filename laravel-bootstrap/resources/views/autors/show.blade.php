@extends('layouts.app')

@section('title', __('autor.detail'))

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">{{ __('autor.detail') }}</div>
            <div class="card-body">
                <table class="table table-sm">
                    <tbody>
                        <tr><td>{{ __('autor.name') }}</td><td>{{ $autor->name }}</td></tr>
                        <tr><td>{{ __('autor.description') }}</td><td>{{ $autor->description }}</td></tr>
                    </tbody>
                </table>
            </div>
            <div class="card-footer">
                @can('update', $autor)
                    <a href="{{ route('autors.edit', $autor) }}" id="edit-autor-{{ $autor->id }}" class="btn btn-warning">{{ __('autor.edit') }}</a>
                @endcan
                <a href="{{ route('autors.index') }}" class="btn btn-link">{{ __('autor.back_to_index') }}</a>
            </div>
        </div>
    </div>
</div>
@endsection

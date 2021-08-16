@extends('layouts.app')

@section('title', __('livro.detail'))

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">{{ __('livro.detail') }}</div>
            <div class="card-body">
                <table class="table table-sm">
                    <tbody>
                        <tr><td>{{ __('livro.name') }}</td><td>{{ $livro->name }}</td></tr>
                        <tr><td>{{ __('livro.description') }}</td><td>{{ $livro->description }}</td></tr>
                    </tbody>
                </table>
            </div>
            <div class="card-footer">
                @can('update', $livro)
                    <a href="{{ route('livros.edit', $livro) }}" id="edit-livro-{{ $livro->id }}" class="btn btn-warning">{{ __('livro.edit') }}</a>
                @endcan
                <a href="{{ route('livros.index') }}" class="btn btn-link">{{ __('livro.back_to_index') }}</a>
            </div>
        </div>
    </div>
</div>
@endsection

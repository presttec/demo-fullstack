@extends('layouts.app')

@section('title', __('genero.detail'))

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">{{ __('genero.detail') }}</div>
            <div class="card-body">
                <table class="table table-sm">
                    <tbody>
                        <tr><td>{{ __('genero.name') }}</td><td>{{ $genero->name }}</td></tr>
                        <tr><td>{{ __('genero.description') }}</td><td>{{ $genero->description }}</td></tr>
                    </tbody>
                </table>
            </div>
            <div class="card-footer">
                @can('update', $genero)
                    <a href="{{ route('generos.edit', $genero) }}" id="edit-genero-{{ $genero->id }}" class="btn btn-warning">{{ __('genero.edit') }}</a>
                @endcan
                <a href="{{ route('generos.index') }}" class="btn btn-link">{{ __('genero.back_to_index') }}</a>
            </div>
        </div>
    </div>
</div>
@endsection

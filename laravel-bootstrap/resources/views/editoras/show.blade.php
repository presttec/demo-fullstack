@extends('layouts.app')

@section('title', __('editora.detail'))

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">{{ __('editora.detail') }}</div>
            <div class="card-body">
                <table class="table table-sm">
                    <tbody>
                        <tr><td>{{ __('editora.nome') }}</td><td>{{ $editora->nome }}</td></tr>
                        <tr><td>{{ __('editora.descricao') }}</td><td>{{ $editora->descricao }}</td></tr>
                    </tbody>
                </table>
            </div>
            <div class="card-footer">
                @can('update', $editora)
                    <a href="{{ route('editoras.edit', $editora) }}" id="edit-editora-{{ $editora->id }}" class="btn btn-warning">{{ __('editora.edit') }}</a>
                @endcan
                <a href="{{ route('editoras.index') }}" class="btn btn-link">{{ __('editora.back_to_index') }}</a>
            </div>
        </div>
    </div>
</div>
@endsection

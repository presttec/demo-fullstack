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
                        <tr><td>{{ __('autor.nome') }}</td><td>{{ $autor->nome }}</td></tr>
                        <tr><td>{{ __('autor.biografia') }}</td><td>{{ $autor->biografia }}</td></tr>
                        <tr><td>{{ __('autor.ano_nascimento') }}</td><td>{{ $autor->ano_nascimento }}</td></tr>
                        <tr><td>{{ __('autor.sexo') }}</td><td>{{ $autor->sexo }}</td></tr>
                        <tr><td>{{ __('autor.nacionalidade') }}</td><td>{{ $autor->nacionalidade }}</td></tr>
                    </tbody>
                </table>
            </div>
            <div class="card-footer">
                <a href="{{ route('autores.index') }}" class="btn btn-link">{{ __('autor.back_to_index') }}</a>
            </div>
        </div>
    </div>
</div>
@endsection

@extends('layouts.app')

@section('title', __('genero.list'))

@section('content')
<div class="mb-3">
    <div class="float-right">
        @can('create', new App\Models\Genero)
            <a href="{{ route('generos.create') }}" class="btn btn-success">{{ __('genero.create') }}</a>
        @endcan
    </div>
    <h1 class="page-title">{{ __('genero.list') }} <small>{{ __('app.total') }} : {{ $generos->total() }} {{ __('genero.genero') }}</small></h1>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <form method="GET" action="" accept-charset="UTF-8" class="form-inline">
                    <div class="form-group">
                        <label for="q" class="form-label">{{ __('genero.search') }}</label>
                        <input placeholder="{{ __('genero.search_text') }}" name="q" type="text" id="q" class="form-control mx-sm-2" value="{{ request('q') }}">
                    </div>
                    <input type="submit" value="{{ __('genero.search') }}" class="btn btn-secondary">
                    <a href="{{ route('generos.index') }}" class="btn btn-link">{{ __('app.reset') }}</a>
                </form>
            </div>
            <table class="table table-sm table-responsive-sm table-hover">
                <thead>
                    <tr>
                        <th class="text-center">{{ __('app.table_no') }}</th>
                        <th>{{ __('genero.nome') }}</th>
                        <th>{{ __('genero.descricao') }}</th>
                        <th class="text-center">{{ __('app.action') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($generos as $key => $genero)
                    <tr>
                        <td class="text-center">{{ $generos->firstItem() + $key }}</td>
                        <td>{!! $genero->name_link !!}</td>
                        <td>{{ $genero->descricao }}</td>
                        <td class="text-center">
                            @can('view', $genero)
                                <a href="{{ route('generos.show', $genero) }}" id="show-genero-{{ $genero->id }}">{{ __('app.show') }}</a>
                            @endcan
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="card-body">{{ $generos->appends(Request::except('page'))->render() }}</div>
        </div>
    </div>
</div>
@endsection

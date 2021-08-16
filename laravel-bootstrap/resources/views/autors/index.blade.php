@extends('layouts.app')

@section('title', __('autor.list'))

@section('content')
<div class="mb-3">
    <div class="float-right">
        @can('create', new App\Models\Autor)
            <a href="{{ route('autores.create') }}" class="btn btn-success">{{ __('autor.create') }}</a>
        @endcan
    </div>
    <h1 class="page-title">{{ __('autor.list') }} <small>{{ __('app.total') }} : {{ $autors->total() }} {{ __('autor.autor') }}</small></h1>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <form method="GET" action="" accept-charset="UTF-8" class="form-inline">
                    <div class="form-group">
                        <label for="q" class="form-label">{{ __('autor.search') }}</label>
                        <input placeholder="{{ __('autor.search_text') }}" name="q" type="text" id="q" class="form-control mx-sm-2" value="{{ request('q') }}">
                    </div>
                    <input type="submit" value="{{ __('autor.search') }}" class="btn btn-secondary">
                    <a href="{{ route('autores.index') }}" class="btn btn-link">{{ __('app.reset') }}</a>
                </form>
            </div>
            <table class="table table-sm table-responsive-sm table-hover">
                <thead>
                    <tr>
                        <th class="text-center">{{ __('app.table_no') }}</th>
                        <th>{{ __('autor.name') }}</th>
                        <th>{{ __('autor.description') }}</th>
                        <th class="text-center">{{ __('app.action') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($autors as $key => $autor)
                    <tr>
                        <td class="text-center">{{ $autors->firstItem() + $key }}</td>
                        <td>{!! $autor->name_link !!}</td>
                        <td>{{ $autor->description }}</td>
                        <td class="text-center">
                            @can('view', $autor)
                                <a href="{{ route('autores.show', $autor) }}" id="show-autor-{{ $autor->id }}">{{ __('app.show') }}</a>
                            @endcan
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="card-body">{{ $autors->appends(Request::except('page'))->render() }}</div>
        </div>
    </div>
</div>
@endsection

@extends('layouts.app')

@section('title', __('livro.list'))

@section('content')
<div class="mb-3">
    <div class="float-right">
        @can('create', new App\Models\Livro)
            <a href="{{ route('livros.create') }}" class="btn btn-success">{{ __('livro.create') }}</a>
        @endcan
    </div>
    <h1 class="page-title">{{ __('livro.list') }} <small>{{ __('app.total') }} : {{ $livros->total() }} {{ __('livro.livro') }}</small></h1>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <form method="GET" action="" accept-charset="UTF-8" class="form-inline">
                    <div class="form-group">
                        <label for="q" class="form-label">{{ __('livro.search') }}</label>
                        <input placeholder="{{ __('livro.search_text') }}" name="q" type="text" id="q" class="form-control mx-sm-2" value="{{ request('q') }}">
                    </div>
                    <input type="submit" value="{{ __('livro.search') }}" class="btn btn-secondary">
                    <a href="{{ route('livros.index') }}" class="btn btn-link">{{ __('app.reset') }}</a>
                </form>
            </div>
            <table class="table table-sm table-responsive-sm table-hover">
                <thead>
                    <tr>
                        <th class="text-center">{{ __('app.table_no') }}</th>
                        <th>{{ __('livro.name') }}</th>
                        <th>{{ __('livro.description') }}</th>
                        <th class="text-center">{{ __('app.action') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($livros as $key => $livro)
                    <tr>
                        <td class="text-center">{{ $livros->firstItem() + $key }}</td>
                        <td>{!! $livro->name_link !!}</td>
                        <td>{{ $livro->description }}</td>
                        <td class="text-center">
                            @can('view', $livro)
                                <a href="{{ route('livros.show', $livro) }}" id="show-livro-{{ $livro->id }}">{{ __('app.show') }}</a>
                            @endcan
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="card-body">{{ $livros->appends(Request::except('page'))->render() }}</div>
        </div>
    </div>
</div>
@endsection

@extends('layouts.app')

@section('title', __('editora.list'))

@section('content')
<div class="mb-3">
    <div class="float-right">
        @can('create', new App\Models\Editora)
            <a href="{{ route('editoras.create') }}" class="btn btn-success">{{ __('editora.create') }}</a>
        @endcan
    </div>
    <h1 class="page-title">{{ __('editora.list') }} <small>{{ __('app.total') }} : {{ $editoras->total() }} {{ __('editora.editora') }}</small></h1>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <form method="GET" action="" accept-charset="UTF-8" class="form-inline">
                    <div class="form-group">
                        <label for="q" class="form-label">{{ __('editora.search') }}</label>
                        <input placeholder="{{ __('editora.search_text') }}" name="q" type="text" id="q" class="form-control mx-sm-2" value="{{ request('q') }}">
                    </div>
                    <input type="submit" value="{{ __('editora.search') }}" class="btn btn-secondary">
                    <a href="{{ route('editoras.index') }}" class="btn btn-link">{{ __('app.reset') }}</a>
                </form>
            </div>
            <table class="table table-sm table-responsive-sm table-hover">
                <thead>
                    <tr>
                        <th class="text-center">{{ __('app.table_no') }}</th>
                        <th>{{ __('editora.name') }}</th>
                        <th>{{ __('editora.description') }}</th>
                        <th class="text-center">{{ __('app.action') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($editoras as $key => $editora)
                    <tr>
                        <td class="text-center">{{ $editoras->firstItem() + $key }}</td>
                        <td>{!! $editora->name_link !!}</td>
                        <td>{{ $editora->description }}</td>
                        <td class="text-center">
                            @can('view', $editora)
                                <a href="{{ route('editoras.show', $editora) }}" id="show-editora-{{ $editora->id }}">{{ __('app.show') }}</a>
                            @endcan
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="card-body">{{ $editoras->appends(Request::except('page'))->render() }}</div>
        </div>
    </div>
</div>
@endsection

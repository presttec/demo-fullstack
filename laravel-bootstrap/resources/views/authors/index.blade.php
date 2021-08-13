@extends('layouts.app')

@section('title', __('author.list'))

@section('content')
<div class="mb-3">
    <div class="float-right">
        @can('create', new App\Models\Author)
            <a href="{{ route('authors.create') }}" class="btn btn-success">{{ __('author.create') }}</a>
        @endcan
    </div>
    <h1 class="page-title">{{ __('author.list') }} <small>{{ __('app.total') }} : {{ $authors->total() }} {{ __('author.author') }}</small></h1>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <form method="GET" action="" accept-charset="UTF-8" class="form-inline">
                    <div class="form-group">
                        <label for="q" class="form-label">{{ __('author.search') }}</label>
                        <input placeholder="{{ __('author.search_text') }}" name="q" type="text" id="q" class="form-control mx-sm-2" value="{{ request('q') }}">
                    </div>
                    <input type="submit" value="{{ __('author.search') }}" class="btn btn-secondary">
                    <a href="{{ route('authors.index') }}" class="btn btn-link">{{ __('app.reset') }}</a>
                </form>
            </div>
            <table class="table table-sm table-responsive-sm table-hover">
                <thead>
                    <tr>
                        <th class="text-center">{{ __('app.table_no') }}</th>
                        <th>{{ __('author.name') }}</th>
                        <th>{{ __('author.description') }}</th>
                        <th class="text-center">{{ __('app.action') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($authors as $key => $author)
                    <tr>
                        <td class="text-center">{{ $authors->firstItem() + $key }}</td>
                        <td>{!! $author->name_link !!}</td>
                        <td>{{ $author->description }}</td>
                        <td class="text-center">
                            @can('view', $author)
                                <a href="{{ route('authors.show', $author) }}" id="show-author-{{ $author->id }}">{{ __('app.show') }}</a>
                            @endcan
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="card-body">{{ $authors->appends(Request::except('page'))->render() }}</div>
        </div>
    </div>
</div>
@endsection

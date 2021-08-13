@extends('layouts.app')

@section('title', __('books.list'))

@section('content')
<div class="mb-3">
    <div class="float-right">
        @can('create', new App\Models\Books)
            <a href="{{ route('books.create') }}" class="btn btn-success">{{ __('books.create') }}</a>
        @endcan
    </div>
    <h1 class="page-title">{{ __('books.list') }} <small>{{ __('app.total') }} : {{ $books->total() }} {{ __('books.books') }}</small></h1>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <form method="GET" action="" accept-charset="UTF-8" class="form-inline">
                    <div class="form-group">
                        <label for="q" class="form-label">{{ __('books.search') }}</label>
                        <input placeholder="{{ __('books.search_text') }}" name="q" type="text" id="q" class="form-control mx-sm-2" value="{{ request('q') }}">
                    </div>
                    <input type="submit" value="{{ __('books.search') }}" class="btn btn-secondary">
                    <a href="{{ route('books.index') }}" class="btn btn-link">{{ __('app.reset') }}</a>
                </form>
            </div>
            <table class="table table-sm table-responsive-sm table-hover">
                <thead>
                    <tr>
                        <th class="text-center">{{ __('app.table_no') }}</th>
                        <th>{{ __('books.name') }}</th>
                        <th>{{ __('books.description') }}</th>
                        <th class="text-center">{{ __('app.action') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($books as $key => $books)
                    <tr>
                        <td class="text-center">{{ $books->firstItem() + $key }}</td>
                        <td>{!! $books->name_link !!}</td>
                        <td>{{ $books->description }}</td>
                        <td class="text-center">
                            @can('view', $books)
                                <a href="{{ route('books.show', $books) }}" id="show-books-{{ $books->id }}">{{ __('app.show') }}</a>
                            @endcan
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="card-body">{{ $books->appends(Request::except('page'))->render() }}</div>
        </div>
    </div>
</div>
@endsection

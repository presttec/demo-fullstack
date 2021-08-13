@extends('layouts.app')

@section('title', __('gender.list'))

@section('content')
<div class="mb-3">
    <div class="float-right">
        @can('create', new App\Models\Gender)
            <a href="{{ route('genders.create') }}" class="btn btn-success">{{ __('gender.create') }}</a>
        @endcan
    </div>
    <h1 class="page-title">{{ __('gender.list') }} <small>{{ __('app.total') }} : {{ $genders->total() }} {{ __('gender.gender') }}</small></h1>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <form method="GET" action="" accept-charset="UTF-8" class="form-inline">
                    <div class="form-group">
                        <label for="q" class="form-label">{{ __('gender.search') }}</label>
                        <input placeholder="{{ __('gender.search_text') }}" name="q" type="text" id="q" class="form-control mx-sm-2" value="{{ request('q') }}">
                    </div>
                    <input type="submit" value="{{ __('gender.search') }}" class="btn btn-secondary">
                    <a href="{{ route('genders.index') }}" class="btn btn-link">{{ __('app.reset') }}</a>
                </form>
            </div>
            <table class="table table-sm table-responsive-sm table-hover">
                <thead>
                    <tr>
                        <th class="text-center">{{ __('app.table_no') }}</th>
                        <th>{{ __('gender.name') }}</th>
                        <th>{{ __('gender.description') }}</th>
                        <th class="text-center">{{ __('app.action') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($genders as $key => $gender)
                    <tr>
                        <td class="text-center">{{ $genders->firstItem() + $key }}</td>
                        <td>{!! $gender->name_link !!}</td>
                        <td>{{ $gender->description }}</td>
                        <td class="text-center">
                            @can('view', $gender)
                                <a href="{{ route('genders.show', $gender) }}" id="show-gender-{{ $gender->id }}">{{ __('app.show') }}</a>
                            @endcan
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="card-body">{{ $genders->appends(Request::except('page'))->render() }}</div>
        </div>
    </div>
</div>
@endsection

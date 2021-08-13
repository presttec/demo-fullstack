@extends('layouts.app')

@section('title', __('gender.detail'))

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">{{ __('gender.detail') }}</div>
            <div class="card-body">
                <table class="table table-sm">
                    <tbody>
                        <tr><td>{{ __('gender.name') }}</td><td>{{ $gender->name }}</td></tr>
                        <tr><td>{{ __('gender.description') }}</td><td>{{ $gender->description }}</td></tr>
                    </tbody>
                </table>
            </div>
            <div class="card-footer">
                @can('update', $gender)
                    <a href="{{ route('genders.edit', $gender) }}" id="edit-gender-{{ $gender->id }}" class="btn btn-warning">{{ __('gender.edit') }}</a>
                @endcan
                <a href="{{ route('genders.index') }}" class="btn btn-link">{{ __('gender.back_to_index') }}</a>
            </div>
        </div>
    </div>
</div>
@endsection

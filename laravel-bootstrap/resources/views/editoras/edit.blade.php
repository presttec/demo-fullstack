@extends('layouts.app')

@section('title', __('editora.edit'))

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        @if (request('action') == 'delete' && $editora)
        @can('delete', $editora)
            <div class="card">
                <div class="card-header">{{ __('editora.delete') }}</div>
                <div class="card-body">
                    <label class="form-label text-primary">{{ __('editora.name') }}</label>
                    <p>{{ $editora->name }}</p>
                    <label class="form-label text-primary">{{ __('editora.description') }}</label>
                    <p>{{ $editora->description }}</p>
                    {!! $errors->first('editora_id', '<span class="invalid-feedback" role="alert">:message</span>') !!}
                </div>
                <hr style="margin:0">
                <div class="card-body text-danger">{{ __('editora.delete_confirm') }}</div>
                <div class="card-footer">
                    <form method="POST" action="{{ route('editoras.destroy', $editora) }}" accept-charset="UTF-8" onsubmit="return confirm(&quot;{{ __('app.delete_confirm') }}&quot;)" class="del-form float-right" style="display: inline;">
                        {{ csrf_field() }} {{ method_field('delete') }}
                        <input name="editora_id" type="hidden" value="{{ $editora->id }}">
                        <button type="submit" class="btn btn-danger">{{ __('app.delete_confirm_button') }}</button>
                    </form>
                    <a href="{{ route('editoras.edit', $editora) }}" class="btn btn-link">{{ __('app.cancel') }}</a>
                </div>
            </div>
        @endcan
        @else
        <div class="card">
            <div class="card-header">{{ __('editora.edit') }}</div>
            <form method="POST" action="{{ route('editoras.update', $editora) }}" accept-charset="UTF-8">
                {{ csrf_field() }} {{ method_field('patch') }}
                <div class="card-body">
                    <div class="form-group">
                        <label for="name" class="form-label">{{ __('editora.name') }} <span class="form-required">*</span></label>
                        <input id="name" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ old('name', $editora->name) }}" required>
                        {!! $errors->first('name', '<span class="invalid-feedback" role="alert">:message</span>') !!}
                    </div>
                    <div class="form-group">
                        <label for="description" class="form-label">{{ __('editora.description') }}</label>
                        <textarea id="description" class="form-control{{ $errors->has('description') ? ' is-invalid' : '' }}" name="description" rows="4">{{ old('description', $editora->description) }}</textarea>
                        {!! $errors->first('description', '<span class="invalid-feedback" role="alert">:message</span>') !!}
                    </div>
                </div>
                <div class="card-footer">
                    <input type="submit" value="{{ __('editora.update') }}" class="btn btn-success">
                    <a href="{{ route('editoras.show', $editora) }}" class="btn btn-link">{{ __('app.cancel') }}</a>
                    @can('delete', $editora)
                        <a href="{{ route('editoras.edit', [$editora, 'action' => 'delete']) }}" id="del-editora-{{ $editora->id }}" class="btn btn-danger float-right">{{ __('app.delete') }}</a>
                    @endcan
                </div>
            </form>
        </div>
    </div>
</div>
@endif
@endsection

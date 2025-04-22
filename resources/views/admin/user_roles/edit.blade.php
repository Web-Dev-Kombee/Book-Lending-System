@extends('layouts.app')

@section('content')
<div class="container">
    <h3>Edit Roles & Permissions for <strong>{{ $user->name }}</strong></h3>

    <form method="POST" action="{{ route('user-role.update', $user) }}">
        @csrf @method('PUT')

        <div class="mb-4">
            <label class="form-label fw-semibold">Roles</label>
            <div class="row">
                @foreach($roles as $role)
                    <div class="col-md-3">
                        <label>
                            <input type="checkbox" name="roles[]" value="{{ $role->name }}"
                                {{ $user->hasRole($role->name) ? 'checked' : '' }}>
                            {{ $role->name }}
                        </label>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="mb-4">
            <label class="form-label fw-semibold">Direct Permissions</label>
            <div class="row">
                @foreach($permissions as $perm)
                    <div class="col-md-3">
                        <label>
                            <input type="checkbox" name="permissions[]" value="{{ $perm->name }}"
                                {{ $user->hasPermissionTo($perm->name) ? 'checked' : '' }}>
                            {{ $perm->name }}
                        </label>
                    </div>
                @endforeach
            </div>
        </div>

        <button class="btn btn-success">Update User</button>
        <a href="{{ route('user-role.index') }}" class="btn btn-secondary">Back</a>
    </form>
</div>
@endsection

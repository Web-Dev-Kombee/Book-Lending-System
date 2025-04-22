@extends('layouts.app')

@section('content')
<div class="container py-4">
    <h2>Edit User</h2>

    <form id="userEditForm" action="{{ route('users.update', $user->id) }}" method="POST" novalidate>
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label>Name</label>
            <input type="text" name="name" class="form-control" required value="{{ old('name', $user->name) }}">
            <div class="invalid-feedback">Name is required.</div>
        </div>

        <div class="mb-3">
            <label>Email</label>
            <input type="email" name="email" class="form-control" required value="{{ old('email', $user->email) }}">
            <div class="invalid-feedback">Please enter a valid email address.</div>
        </div>

        <div class="mb-3">
            <label>New Password <small class="text-muted">(leave blank to keep current)</small></label>
            <input type="password" name="password" class="form-control" minlength="6">
            <div class="invalid-feedback">Password must be at least 6 characters.</div>
        </div>

        <div class="mb-3">
            <label>Confirm New Password</label>
            <input type="password" name="password_confirmation" class="form-control">
            <div class="invalid-feedback">Passwords must match.</div>
        </div>

        <div class="mb-3">
            <label>Assign Role</label>
            <select name="role" class="form-select">
                <option value="">-- None --</option>
                @foreach($roles as $role)
                    <option value="{{ $role->name }}"
                        {{ $user->roles->pluck('name')->contains($role->name) ? 'selected' : '' }}>
                        {{ ucfirst($role->name) }}
                    </option>
                @endforeach
            </select>
        </div>

        <button class="btn btn-primary">Update</button>
        <a href="{{ route('users.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>

{{-- Real-time Validation Script --}}
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const form = document.getElementById('userEditForm');

        const password = form.querySelector('[name="password"]');
        const passwordConfirmation = form.querySelector('[name="password_confirmation"]');

        const validateField = (field) => {
            if (!field.checkValidity()) {
                field.classList.add('is-invalid');
                field.classList.remove('is-valid');
            } else {
                field.classList.remove('is-invalid');
                field.classList.add('is-valid');
            }
        };

        const validatePasswordMatch = () => {
            if (password.value !== passwordConfirmation.value) {
                passwordConfirmation.setCustomValidity('Passwords do not match');
            } else {
                passwordConfirmation.setCustomValidity('');
            }
            validateField(passwordConfirmation);
        };

        Array.from(form.elements).forEach(input => {
            if (input.tagName !== 'BUTTON') {
                input.addEventListener('input', () => {
                    if (input.name === 'password' || input.name === 'password_confirmation') {
                        validatePasswordMatch();
                    } else {
                        validateField(input);
                    }
                });
            }
        });

        form.addEventListener('submit', function (e) {
            validatePasswordMatch();

            if (!form.checkValidity()) {
                e.preventDefault();
                e.stopPropagation();
                Array.from(form.elements).forEach(validateField);
            }
        });
    });
</script>
@endsection

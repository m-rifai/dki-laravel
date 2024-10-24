@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Edit User</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Whoops!</strong> There were some problems with your input.<br><br>
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('users.update', $user->id) }}" method="POST">
        @csrf
        @method('PUT')

        <!-- Name -->
        <div class="mb-3">
            <label for="name" class="form-label">Name <span class="text-danger">*</span></label>
            <input type="text" name="name" class="form-control" id="name" value="{{ old('name', $user->name) }}" required>
        </div>

        <!-- Email -->
        <div class="mb-3">
            <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
            <input type="email" name="email" class="form-control" id="email" value="{{ old('email', $user->email) }}" required>
        </div>

        <!-- Password -->
        <div class="mb-3">
            <label for="password" class="form-label">Password <small class="text-muted">(Leave blank to keep current password)</small></label>
            <input type="password" name="password" class="form-control" id="password">
        </div>

        <!-- Confirm Password -->
        <div class="mb-3">
            <label for="password_confirmation" class="form-label">Confirm Password</label>
            <input type="password" name="password_confirmation" class="form-control" id="password_confirmation">
        </div>

        <!-- Role -->
        <div class="mb-3">
            <label for="role" class="form-label">Role <span class="text-danger">*</span></label>
            <select name="role" id="role" class="form-select" required>
                <option value="">-- Select Role --</option>
                @foreach($roles as $role)
                    <option value="{{ $role->id }}" {{ ($user->role && $user->role->id === $role->id) ? 'selected' : '' }}>
                        {{ ucfirst($role->name) }}
                    </option>
                @endforeach
            </select>
        </div>

        <!-- Is Blocked -->
        <div class="mb-3 form-check">
            <input type="checkbox" name="is_blocked" class="form-check-input" id="is_blocked" {{ $user->is_blocked ? 'checked' : '' }}>
            <label class="form-check-label" for="is_blocked">Is Blocked</label>
        </div>

        <!-- Submit Button -->
        <button type="submit" class="btn btn-primary">Update User</button>
        <a href="{{ route('users.index') }}" class="btn btn-secondary">Back</a>
    </form>
</div>
@endsection

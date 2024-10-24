<!-- resources/views/users/index.blade.php -->

@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">User Management</h1>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <a href="{{ route('users.create') }}" class="btn btn-primary mb-3">Add New User</a>

    <table class="table table-bordered" id="users-table">
        <thead>
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Email</th>
                <th>Role</th>
                <th>Blocked</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        $('#users-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{{ route('users.index') }}',
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                { data: 'name', name: 'name' },
                { data: 'email', name: 'email' },
                { data: 'role', name: 'role.name' },
                { data: 'blocked', name: 'is_blocked', orderable: false, searchable: false },
                { data: 'actions', name: 'actions', orderable: false, searchable: false },
            ],
            order: [[1, 'asc']],
            columnDefs: [
                { targets: 0, width: '50px' },
                { targets: 5, width: '150px' },
            ],
            language: {
                processing: '<div class="spinner-border text-primary" role="status"><span class="visually-hidden">Loading...</span></div>'
            },

            responsive: true,
        });
    });
</script>
@endpush

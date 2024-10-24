@extends('layouts.app')

@section('content')
<div class="container">
    <h2>User yang Terblokir</h2>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if($blockedUsers->isEmpty())
        <p>Tidak ada user yang terblokir.</p>
    @else
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($blockedUsers as $user)
                    <tr>
                        <td>{{ $user->id }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->role->name }}</td>
                        <td>
                            <form action="{{ route('users.unblock', $user->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-warning btn-sm">Unblock</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection

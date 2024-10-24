<!-- resources/views/applications/index.blade.php -->

@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">Daftar Pengajuan Pembukaan Rekening</h2>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <a href="{{ route('applications.create') }}" class="btn btn-primary mb-3">Ajukan Pembukaan Rekening</a>

    <table class="table table-bordered" id="applications-table">
        <thead>
            <tr>
                <th>#</th>
                <th>Nama</th>
                <th>Status</th>
                <th>Waktu Pengajuan</th>
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
        $('#applications-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{{ route('applications.index') }}',
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                { data: 'full_name', name: 'full_name' },
                { data: 'status_badge', name: 'status', orderable: false, searchable: false },
                { data: 'waktu_pengajuan', name: 'created_at' },
            ],
            order: [[1, 'asc']],
            columnDefs: [
                { targets: 0, width: '50px' },
            ],
            language: {
                processing: '<div class="spinner-border text-primary" role="status"><span class="visually-hidden">Loading...</span></div>'
            },
            responsive: true,
        });
    });
</script>
@endpush

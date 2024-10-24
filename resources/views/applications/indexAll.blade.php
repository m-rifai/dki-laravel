@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Semua Pengajuan Pembukaan Rekening</h2>

    @if(Auth::user()->role->name === 'Supervisor')
        <table class="table table-bordered" id="applications-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nama</th>
                    <th>Pekerjaan</th>
                    <th>Alamat</th>
                    <th>Nominal Setor</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
        </table>
    @else
        <p>Anda tidak memiliki izin untuk melihat halaman ini.</p>
    @endif
</div>
@endsection

@push('scripts')
    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>
    <link href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css" rel="stylesheet">

    <script>
        $(function() {
            $('#applications-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('applications.indexAll') }}",
                columns: [
                    { data: 'id', name: 'id' },
                    { data: 'full_name', name: 'full_name' },
                    { data: 'job.name', name: 'job.name' },
                    { data: 'address', name: 'address', orderable: false, searchable: false },
                    { data: 'deposit_amount', name: 'deposit_amount' },
                    { data: 'status', name: 'status' },
                    { data: 'action', name: 'action', orderable: false, searchable: false },
                ]
            });

            // Handle Approve Button Click
            $('#applications-table').on('click', '.approve', function(){
                var applicationId = $(this).data('id');
                if(confirm("Apakah Anda yakin ingin menyetujui pengajuan ini?")){
                    $.ajax({
                        url: '/applications/' + applicationId + '/approve',
                        type: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response){
                            alert(response.success);
                            $('#applications-table').DataTable().ajax.reload();
                        },
                        error: function(xhr){
                            alert('Terjadi kesalahan saat menyetujui pengajuan.');
                        }
                    });
                }
            });
        });
    </script>
@endpush

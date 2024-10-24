<!-- resources/views/layouts/app.blade.php -->

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

    <!-- DataTables CSS (Jika Dibutuhkan di Banyak View) -->
    <link href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <style>
        body {
            font-size: .875rem;
        }

        .sidebar {
            height: 100vh;
            position: fixed;
            top: 0;
            /* Start from below the navbar */
            left: 0;
            z-index: 100;
            padding-top: 60px; /* Height of navbar */
            box-shadow: inset -1px 0 0 rgba(0, 0, 0, .1);
        }

        .sidebar .nav-link {
            color: #333;
        }

        .sidebar .nav-link.active {
            background-color: #e9ecef;
            font-weight: bold;
        }

        /* resources/views/layouts/app.blade.php */

    .sidebar .nav-link:hover {
        background-color: #e9ecef;
        color: #000;
    }

    .sidebar .nav-link i {
        font-size: 1.2rem;
    }

    /* Active link styling */
    .sidebar .nav-link.active {
        color: #0d6efd;
        background-color: #e9ecef;
    }


        main {
            margin-left: 250px; /* Width of the sidebar */
            padding: 20px;
        }

        @media (max-width: 768px) {
            .sidebar {
                display: none;
            }

            main {
                margin-left: 0;
            }
        }
    </style>

    <!-- Stack untuk Styles Tambahan -->
    @stack('styles')
</head>
<body>
    <!-- Navbar -->
    @include('layouts.navigation')

    <!-- Sidebar -->
    @include('layouts.sidebar')

    <!-- Main Content -->
    <main class="pt-4">
        <div class="container-fluid">
            <!-- Header (Jika Ada) -->
            @if (isset($header))
                <header class="my-4">
                    <h1 class="h2">{{ $header }}</h1>
                </header>
            @endif

            <!-- Page Content -->
            @yield('content')
        </div>
    </main>

    <!-- jQuery (Diperlukan untuk DataTables dan Interaksi Lainnya) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- DataTables JS (Jika Dibutuhkan di Banyak View) -->
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>

    <!-- Custom Scripts -->
    <script>
        $(document).ready(function() {
            // Inisialisasi DataTables jika diperlukan
            $('.datatable').DataTable();
        });
    </script>

    <!-- Stack untuk Scripts Tambahan -->
    @stack('scripts')
</body>
</html>

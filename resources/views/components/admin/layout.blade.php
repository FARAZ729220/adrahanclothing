<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Product | Admin Adrahan</title>
    <link href="{{ asset('css/bootstrap/bootstrap.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('css/aos/aos.css') }}" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link href="{{ asset('css/admin/style.css') }}" rel="stylesheet" />

    <link href="{{ asset('css/admin/datatable.css') }}" rel="stylesheet">
</head>

<body>

    <header class="admin-header">
        <div class="container-fluid d-flex justify-content-between align-items-center">
            <h1 class="admin-logo">ADMIN</h1>
            <form action="{{ route('admin.logout') }}" method="POST">
                @csrf
                <button type="submit"
                    class="nav-link-admin small text-danger border-0 bg-transparent p-0 w-100 text-start">
                    <i class="bi bi-box-arrow-right"></i> Logout
                </button>
            </form>
        </div>
    </header>

    <div class="py-3 m-5">
        <a href="{{ route('admin.dashboard') }}" class="back-link"><i class="bi bi-arrow-left"></i> Back to
        Dashboard</a>
    </div>

    {{ $slot }}

    <!-- jQuery FIRST -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <!-- Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <!-- DataTables -->
    <script src="https://cdn.datatables.net/2.3.7/js/dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/2.3.7/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</body>

</html>

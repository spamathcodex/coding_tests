<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Vetencode - Distribution</title>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>

<body class="bg-light">
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary mb-4">
        <div class="container">
            <a class="navbar-brand fw-semibold" href="{{ route('distributions.index') }}">Vetencode</a>
            <div class="collapse navbar-collapse">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item"><a href="{{ route('distributions.index') }}" class="nav-link">Distributions</a>
                    </li>
                </ul>
                {{-- <a href="{{ route('distributions.create') }}" class="btn btn-light text-primary fw-semibold">Tambah
                    Distribusi</a> --}}
            </div>
        </div>
    </nav>


    <div class="container bg-white shadow-sm p-4 rounded-3">
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif


        @yield('content')
    </div>

    @stack('scripts')
</body>

</html>
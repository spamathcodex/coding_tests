<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Vetencode - Distribution</title>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>

<body>
    <div class="container" style="padding:20px;">
        @if(session('success'))
            <div style="background:#d4edda;padding:10px;border-radius:6px">{{ session('success') }}</div>
        @endif


        @yield('content')
    </div>


    @stack('scripts')
</body>

</html>

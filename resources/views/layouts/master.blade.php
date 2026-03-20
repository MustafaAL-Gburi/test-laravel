<!DOCTYPE html>
<html>

<head>
    <title>@yield('page_title', 'App')</title>

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- CSS (إذا عندك Bootstrap أو غيره ضيفه هنا) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- FontAwesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            padding: 20px;
            font-family: Arial;
            background: #f5f5f5;
        }

        table {
            background: white;
            border-collapse: collapse;
        }

        th,
        td {
            padding: 8px;
            border: 1px solid #ccc;
        }
    </style>
</head>

<body>

    <h2>@yield('page_title')</h2>

    <div>
        @yield('content')
    </div>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- main.js -->
    <script src="/js/main.js"></script>

    @stack('scripts')

</body>

</html>

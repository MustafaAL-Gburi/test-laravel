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
        /* Dialog overlay */
        .dialog-overlay {
            position: fixed !important;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            z-index: 9998;
        }

        /* Dialog box */
        .dialog {
            position: fixed !important;
            background: white;
            min-width: 300px;
            max-width: 600px;
            padding: 20px;
            border-radius: 10px;
            z-index: 9999;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.3);
        }

        /* Title */
        .dialog-titlebar {
            font-weight: bold;
            margin-bottom: 10px;
        }

        /* Close button */
        .dialog-close-btn {
            position: absolute;
            top: 10px;
            right: 15px;
            cursor: pointer;

        }

        .dialog {
            top: 50% !important;
            left: 50% !important;
            transform: translate(-50%, -50%);
        }

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


    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    @stack('scripts')

</body>

</html>

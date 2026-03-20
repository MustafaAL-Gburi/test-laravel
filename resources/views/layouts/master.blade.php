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

    <!-- Custom Styles -->
    <link rel="stylesheet" href="/css/custom.css">


    <style>
        /* ===== TABLE DARK STYLE ===== */

        #data-table {
            width: 100%;
            border-collapse: collapse;
            background: #2b2b2b;
            color: #ddd;
        }

        /* Header */
        #data-table thead {
            background: #1f1f1f;
        }

        #data-table th {
            padding: 10px;
            text-align: left;
            font-size: 14px;
            color: #aaa;
            border-bottom: 1px solid #444;
        }

        /* Rows */
        #data-table td {
            padding: 8px 10px;
            border-bottom: 1px solid #3a3a3a;
        }

        /* Zebra rows */
        #data-table tbody tr:nth-child(even) {
            background: #2f2f2f;
        }

        /* Hover */
        #data-table tbody tr:hover {
            background: #3a3a3a;
        }

        /* Actions icons */
        #data-table .actions a {
            color: #bbb;
            margin-right: 8px;
            text-decoration: none;
        }

        #data-table .actions a:hover {
            color: #fff;
        }

        /* Delete icon */
        .icon-danger {
            color: #ff4d4d !important;
        }

        .icon-danger:hover {
            color: #ff1a1a !important;
        }

        /* Overlay */
        .dialog-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.6);
            z-index: 9998;
        }

        /* Modal */
        .dialog {
            position: fixed;
            top: 50% !important;
            left: 50% !important;
            transform: translate(-50%, -50%);
            background: #1e1e1e;
            color: #ddd;
            width: 600px;
            border-radius: 6px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.5);
            z-index: 9999;
            padding: 0;
        }

        /* Header */
        .dialog-titlebar {
            background: #111;
            color: #ff9900;
            padding: 10px 15px;
            font-weight: bold;
            border-bottom: 1px solid #333;
        }

        /* Content */
        .dialog-content {
            padding: 20px;
        }

        /* Labels */
        .dialog label {
            color: #bbb;
            font-size: 14px;
        }

        /* Inputs */
        .dialog input,
        .dialog select {
            width: 100%;
            background: #111;
            border: 1px solid #333;
            color: #fff;
            padding: 8px;
            border-radius: 4px;
            margin-bottom: 10px;
        }

        /* Buttons */
        .dialog .btn-success {
            background: #28a745;
            border: none;
        }

        .dialog .btn-secondary {
            background: #6c757d;
            border: none;
        }

        /* Close button */
        .dialog-close-btn {
            position: absolute;
            right: 10px;
            top: 8px;
            color: #fff;
            cursor: pointer;
        }

        /* Table row hover */
        #data-table tbody tr {
            transition: 0.2s;
            cursor: pointer;
        }
    </style>
</head>

<body>
    @yield('leftpanel')

    @yield('Help')

    <div class="breadcrump">
        @yield('breadcrump')
    </div>

    <div>
        @yield('content')
    </div>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- main.js -->
    <script src="/js/main.js"></script>


    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <div id="toast-container"
        style="
    position: fixed;
    top: 20px;
    left: 50%;
    transform: translateX(-50%);
    z-index: 9999;
    width: 100%;
    display: flex;
    justify-content: center;
    pointer-events: none;
">
    </div>
    <div id="spinner"
        style="
    display:none;
    position: fixed;
    top:0;left:0;
    width:100%;height:100%;
    background: rgba(0,0,0,0.3);
    z-index:9999;
">
        <div
            style="
        position:absolute;
        top:50%;left:50%;
        transform:translate(-50%,-50%);
        color:white;
        font-size:20px;
    ">
            Loading...
        </div>
    </div>

    @stack('scripts')

</body>

</html>

<!DOCTYPE html>
<html>

<head>
    <title>@yield('page_title', 'Beruf Management')</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Bootstrap & FontAwesome -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">

    <style>
        /* ===== GLOBAL ===== */
        body {
            margin: 0;
            background: #1c1c1c;
            color: #ddd;
            font-family: Arial, sans-serif;
        }

        /* ===== LAYOUT ===== */
        .app-layout {
            display: flex;
            min-height: 100vh;
        }

        /* ===== SIDEBAR ===== */
        .sidebar {
            width: 260px;
            min-width: 260px;
            height: 100vh;
            background: #252525;
            border-right: 1px solid #333;
            position: fixed;
            left: 0;
            top: 0;
            z-index: 1000;
            overflow-y: auto;
            padding: 15px;
        }

        .sidebar ul {
            list-style: none;
            padding: 0;
        }

        .sidebar li {
            margin-bottom: 10px;
        }

        .sidebar a {
            display: block;
            padding: 8px 10px;
            color: #ccc;
            text-decoration: none;
            border-radius: 4px;
            transition: 0.2s;
        }

        .sidebar a:hover {
            background: #333;
            color: #ff9900;
        }

        .sidebar input {
            width: 100%;
            background: #111;
            border: 1px solid #333;
            color: #fff;
            padding: 8px;
            border-radius: 4px;
        }

        /* ===== MAIN CONTENT ===== */
        .main-content {
            margin-left: 260px;
            width: calc(100% - 260px);
            padding: 20px;
        }

        /* ===== TABLE ===== */
        #data-table {
            width: 100%;
            min-width: 600px;
            border-collapse: collapse;
            background: #222;
            border-radius: 6px;
            overflow: hidden;
            color: #ddd;
        }

        #data-table thead {
            background: #111;
        }

        #data-table th {
            padding: 10px;
            color: #ff9900;
            font-weight: bold;
            border-bottom: 1px solid #333;
            position: relative;
            padding-right: 30px;
        }

        #data-table td {
            padding: 8px 10px;
            border-bottom: 1px solid #2e2e2e;
        }

        #data-table tbody tr:nth-child(even) {
            background: #262626;
        }

        #data-table tbody tr:hover {
            background: #333;
        }

        /* ===== SORT ICONS ===== */
        #data-table th .at-sort-asc,
        #data-table th .at-sort-desc {
            position: absolute;
            right: 8px;
            font-size: 10px;
            color: #666;
            cursor: pointer;
            transition: 0.2s;
        }

        #data-table th .at-sort-asc {
            top: 6px;
        }

        #data-table th .at-sort-desc {
            bottom: 6px;
        }

        #data-table th .at-sort-asc:hover,
        #data-table th .at-sort-desc:hover,
        #data-table th .at-sort-asc.active,
        #data-table th .at-sort-desc.active {
            color: #ff9900;
        }

        #data-table th.at-sortable {
            cursor: pointer;
        }

        /* ===== ACTION ICONS ===== */
        #data-table .actions a {
            color: #aaa;
            transition: 0.2s;
        }

        #data-table .actions a:hover {
            color: #ff9900;
        }

        .icon-danger {
            color: #ff4d4d !important;
        }

        .icon-danger:hover {
            color: #ff1a1a !important;
        }

        /* ===== DIALOG ===== */
        .dialog-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.6);
            z-index: 9998;
        }

        .dialog {
            position: fixed !important;
            top: 50% !important;
            left: 50% !important;
            transform: translate(-50%, -50%) !important;
            width: 650px;
            max-width: 90%;
            background: #1e1e1e;
            color: #ddd;
            border: 1px solid #333;
            border-radius: 0;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.6);
            z-index: 9999;
            animation: scaleIn 0.2s ease;
        }

        @keyframes scaleIn {
            from {
                transform: translate(-50%, -60%) scale(0.9);
                opacity: 0;
            }

            to {
                transform: translate(-50%, -50%) scale(1);
                opacity: 1;
            }
        }

        .dialog-titlebar {
            background: #111 !important;
            color: #ff9900 !important;
            font-weight: bold;
            padding: 12px 15px;
            border-bottom: 1px solid #333;
            border-radius: 0;
        }

        .dialog-content {
            padding: 20px;
            border-radius: 0;
        }

        .dialog label {
            color: #aaa;
            font-size: 13px;
            margin-bottom: 5px;
            display: block;
        }

        .dialog input,
        .dialog select,
        .dialog textarea {
            width: 100%;
            background: #111 !important;
            border: 1px solid #333 !important;
            color: #fff !important;
            padding: 8px;
            border-radius: 4px;
            margin-bottom: 12px;
        }

        .dialog input:focus,
        .dialog select:focus {
            border-color: #ff9900 !important;
            outline: none;
        }

        .dialog-close-btn {
            position: absolute;
            top: 10px;
            right: 12px;
            font-size: 18px;
            color: #aaa;
            background: none;
            border: none;
            text-decoration: none;
        }

        .dialog-close-btn:hover {
            color: #fff;
        }

        /* ===== BUTTONS ===== */
        .btn-success {
            background: #28a745 !important;
            border: none;
        }

        .btn-success:hover {
            background: #218838 !important;
        }

        .btn-secondary {
            background: #6c757d !important;
            border: none;
        }

        /* ===== PAGINATION ===== */
        .pagination {
            margin: 0;
        }

        .pagination .page-item {
            margin: 0 2px;
        }

        .pagination .page-link {
            background: #222;
            color: #ccc;
            border: 1px solid #333;
            padding: 5px 10px;
        }

        .pagination .page-link:hover {
            background: #333;
            color: #ff9900;
        }

        .pagination .active .page-link {
            background: #ff9900;
            color: #000;
            border-color: #ff9900;
        }

        .pagination-numbers {
            display: flex;
            align-items: center;
        }

        .pagination-info {
            font-size: 13px;
            color: #aaa;
        }

        /* ===== TABLE CONTAINER ===== */
        #results {
            width: 100%;
            overflow-x: auto;
        }

        /* ===== TOAST CONTAINER ===== */
        #toast-container {
            position: fixed;
            top: 20px;
            left: 50%;
            transform: translateX(-50%);
            z-index: 9999;
        }

        /* ===== SPINNER ===== */
        #spinner {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.3);
            z-index: 9999;
        }

        #spinner>div {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            color: white;
            font-size: 16px;
        }
    </style>
</head>

<body>
    <div class="app-layout">
        {{-- Sidebar --}}
        <aside class="sidebar">
            @yield('leftpanel')
        </aside>

        {{-- Main Content --}}
        <main class="main-content">
            @yield('breadcrump')
            @yield('content')
        </main>
    </div>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="/js/main.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Toast Container -->
    <div id="toast-container"></div>

    <!-- Spinner -->
    <div id="spinner">
        <div>Loading...</div>
    </div>

    @stack('scripts')
</body>

</html>

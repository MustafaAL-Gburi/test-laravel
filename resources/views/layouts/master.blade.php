<!DOCTYPE html>
<html>

<head>
    <title>@yield('page_title', 'App')</title>

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- FontAwesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">

    <style>
        body {
            margin: 0;
            background: #1f1f1f;
            color: #ddd;
            font-family: Arial, sans-serif;
        }

        /* ===== LAYOUT ===== */
        .app-container {
            display: flex;
        }

        /* ===== SIDEBAR ===== */
        .sidebar {
            width: 260px;
            background: #2b2f33;
            height: 100vh;
            position: fixed;
            left: 0;
            top: 0;
            padding: 15px;
            z-index: 1000;
        }

        .sidebar ul {
            list-style: none;
            padding: 0;
        }

        .sidebar li {
            margin-bottom: 10px;
        }

        .sidebar a {
            color: #9ecfff;
            text-decoration: none;
            display: block;
            padding: 6px 10px;
        }

        .sidebar a:hover {
            background: #3a3f45;
        }

        .sidebar input {
            width: 100%;
            background: #1f2327;
            border: 1px solid #444;
            color: #fff;
            padding: 8px;
        }

        /* ===== CONTENT ===== */
        .main-content {
            margin-left: 260px;
            padding: 20px;
            width: calc(100% - 260px);
        }

        /* ===== TABLE ===== */
        #data-table {
            width: 100%;
            border-collapse: collapse;
            background: #2b2b2b;
            color: #ddd;
        }

        #data-table thead {
            background: #1f1f1f;
        }

        #data-table th {
            padding: 10px;
            color: #aaa;
            border-bottom: 1px solid #444;
        }

        #data-table td {
            padding: 8px 10px;
            border-bottom: 1px solid #3a3a3a;
        }

        #data-table tbody tr:nth-child(even) {
            background: #2f2f2f;
        }

        #data-table tbody tr:hover {
            background: #3a3a3a;
        }

        .icon-danger {
            color: #ff4d4d !important;
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
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 600px;
            background: #1e1e1e;
            color: #ddd;
            border-radius: 6px;
            z-index: 9999;
        }

        .dialog-titlebar {
            background: #111;
            color: #ff9900;
            padding: 10px;
        }

        .dialog-content {
            padding: 20px;
        }

        /* زر الإغلاق (نظيف 👌) */
        .dialog-close-btn {
            position: absolute;
            right: 12px;
            top: 10px;
            font-size: 18px;
            color: #aaa;
            text-decoration: none;
            border: none;
            background: none;
        }

        .dialog-close-btn:hover {
            color: #fff;
        }

        /* ===== LAYOUT FIX ===== */
        .app-layout {
            display: flex;
        }

        /* ===== SIDEBAR ===== */
        .sidebar {
            width: 260px;
            min-width: 260px;
            height: 100vh;
            background: #2b2f33;
            position: fixed;
            left: 0;
            top: 0;
            z-index: 1000;
            overflow-y: auto;
            padding: 15px;
        }

        /* ===== CONTENT ===== */
        .main-content {
            margin-left: 260px;
            width: calc(100% - 260px);
            padding: 20px;
        }

        /* ===== FIX TABLE OVERFLOW 🔥 ===== */
        #results {
            width: 100%;
            overflow-x: auto;
        }

        /* يخلي الجدول ما يكسر التصميم */
        #data-table {
            min-width: 600px;
        }

        /* ===== SIDEBAR FIX ===== */
        .sidebar ul {
            list-style: none;
            padding: 0;
        }

        .sidebar a {
            display: block;
            padding: 8px 10px;
            color: #9ecfff;
        }

        .sidebar a:hover {
            background: #3a3f45;
        }

        /* ===== GLOBAL ===== */
        body {
            background: #1c1c1c;
            color: #ddd;
        }

        /* ===== SIDEBAR ===== */
        .sidebar {
            background: #252525;
            border-right: 1px solid #333;
        }

        .sidebar a {
            color: #ccc;
            border-radius: 4px;
            transition: 0.2s;
        }

        .sidebar a:hover {
            background: #333;
            color: #ff9900;
        }

        /* input داخل sidebar */
        .sidebar input {
            background: #111;
            border: 1px solid #333;
            color: #fff;
        }

        /* ===== TABLE ===== */
        #data-table {
            background: #222;
            border-radius: 6px;
            overflow: hidden;
        }

        /* header */
        #data-table thead {
            background: #111;
        }

        #data-table th {
            color: #ff9900;
            font-weight: bold;
            border-bottom: 1px solid #333;
        }

        /* rows */
        #data-table td {
            border-bottom: 1px solid #2e2e2e;
        }

        /* zebra */
        #data-table tbody tr:nth-child(even) {
            background: #262626;
        }

        /* hover */
        #data-table tbody tr:hover {
            background: #333;
        }

        /* ===== ACTION ICONS ===== */
        #data-table .actions a {
            color: #aaa;
            transition: 0.2s;
        }

        #data-table .actions a:hover {
            color: #ff9900;
        }

        /* delete */
        .icon-danger {
            color: #ff4d4d !important;
        }

        .icon-danger:hover {
            color: #ff1a1a !important;
        }

        /* ===== DIALOG (نفسه بس تحسين) ===== */
        .dialog {
            background: #1e1e1e;
        }

        .dialog-titlebar {
            background: #111;
            color: #ff9900;
        }

        /* ===== BUTTONS ===== */
        .btn-success {
            background: #ff9900 !important;
            border: none;
        }

        .btn-success:hover {
            background: #e68a00 !important;
        }

        .btn-secondary {
            background: #444 !important;
            border: none;
        }

        /* ===== INPUTS ===== */
        input,
        select {
            background: #111 !important;
            border: 1px solid #333 !important;
            color: #fff !important;
        }

        /* ===== PAGINATION ===== */
        .pagination .page-link {
            background: #222;
            color: #ccc;
            border: 1px solid #333;
        }

        .pagination .page-link:hover {
            background: #333;
            color: #ff9900;
        }

        .pagination .active .page-link {
            background: #ff9900;
            border-color: #ff9900;
            color: #000;
        }

        /* ===== SORT ICON FIX ===== */
        #data-table th {
            position: relative;
            padding-right: 30px;
            /* مساحة للأيقونات */
        }

        /* container للأيقونات */
        #data-table th .at-sort-asc,
        #data-table th .at-sort-desc {
            position: absolute;
            right: 8px;
            font-size: 10px;
            color: #666;
            cursor: pointer;
            transition: 0.2s;
        }

        /* ترتيبهم فوق/تحت */
        #data-table th .at-sort-asc {
            top: 6px;
        }

        #data-table th .at-sort-desc {
            bottom: 6px;
        }

        /* hover */
        #data-table th .at-sort-asc:hover,
        #data-table th .at-sort-desc:hover {
            color: #ff9900;
        }

        /* active */
        #data-table th .at-sort-asc.active,
        #data-table th .at-sort-desc.active {
            color: #ff9900;
        }

        /* لما يكون sortable */
        #data-table th.at-sortable {
            cursor: pointer;
        }

        /* ===== SORT ICON FIX ===== */
        #data-table th {
            position: relative;
            padding-right: 30px;
            /* مساحة للأيقونات */
        }

        /* container للأيقونات */
        #data-table th .at-sort-asc,
        #data-table th .at-sort-desc {
            position: absolute;
            right: 8px;
            font-size: 10px;
            color: #666;
            cursor: pointer;
            transition: 0.2s;
        }

        /* ترتيبهم فوق/تحت */
        #data-table th .at-sort-asc {
            top: 6px;
        }

        #data-table th .at-sort-desc {
            bottom: 6px;
        }

        /* hover */
        #data-table th .at-sort-asc:hover,
        #data-table th .at-sort-desc:hover {
            color: #ff9900;
        }

        /* active */
        #data-table th .at-sort-asc.active,
        #data-table th .at-sort-desc.active {
            color: #ff9900;
        }

        /* لما يكون sortable */
        #data-table th.at-sortable {
            cursor: pointer;
        }

        /* ===== DIALOG FULL FIX ===== */
        .dialog {
            background: #1e1e1e !important;
            color: #ddd;
            width: 650px;
            border-radius: 6px;
        }

        /* العنوان */
        .dialog-titlebar {
            background: #111 !important;
            color: #ff9900 !important;
            font-weight: bold;
            padding: 12px 15px;
            border-bottom: 1px solid #333;
        }

        /* المحتوى */
        .dialog-content {
            padding: 20px;
        }

        /* labels */
        .dialog label {
            color: #aaa;
            font-size: 13px;
            margin-bottom: 5px;
            display: block;
        }

        /* inputs 🔥 */
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

        /* focus */
        .dialog input:focus,
        .dialog select:focus {
            border-color: #ff9900 !important;
            outline: none;
        }

        /* buttons */
        .dialog .btn-success {
            background: #28a745;
            border: none;
        }

        .dialog .btn-secondary {
            background: #6c757d;
            border: none;
        }

        /* button bar */
        .buttonbar {
            display: flex;
            justify-content: space-between;
            margin-top: 15px;
        }

        /* close button */
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

        .dialog {
            position: fixed !important;
            top: 50% !important;
            left: 50% !important;

            transform: translate(-50%, -50%) !important;

            width: 650px;
            max-width: 90%;

            background: #1e1e1e;
            z-index: 9999;
        }

        .dialog {
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

        .dialog {
            border-radius: 0 !important;
            border: 1px solid #333;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.6);
        }

        .dialog-titlebar {
            border-radius: 0 !important;
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

        .pagination-numbers {
            display: flex;
            align-items: center;
        }

        .pagination-info {
            font-size: 13px;
            color: #aaa;
        }

        .pagination .active .page-link {
            background: #ff9900;
            color: #000;
            border-color: #ff9900;
        }

        .dialog-content {
            border-radius: 0 !important;
        }

        .dialog input {
            background: #111 !important;
        }

        .dialog-close-btn:hover {
            color: #fff;
        }
    </style>
</head>

<body>

    <div class="app-container">

        {{-- Sidebar --}}


        {{-- Content --}}
        <div class="main-content">
            @yield('breadcrump')
            @yield('content')
        </div>

    </div>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- main.js -->
    <script src="/js/main.js"></script>

    <!-- Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Toast -->
    <div id="toast-container" style="position: fixed; top:20px; left:50%; transform:translateX(-50%); z-index:9999;">
    </div>

    <!-- Spinner -->
    <div id="spinner"
        style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.3); z-index:9999;">
        <div style="position:absolute; top:50%; left:50%; transform:translate(-50%,-50%); color:white;">
            Loading...
        </div>
    </div>
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
    @stack('scripts')

</body>

</html>

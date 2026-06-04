<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Dine Restaurant')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <style>
        body { background:#f5f6fa; font-family: system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif; }
        .app-shell { min-height:100vh; display:grid; grid-template-columns: 260px 1fr; }
        .sidebar { background:#151923; color:#fff; padding:1.25rem; }
        .sidebar a { color:#dfe6f3; text-decoration:none; display:flex; align-items:center; gap:.6rem; padding:.75rem .9rem; border-radius:.8rem; margin-bottom:.35rem; }
        .sidebar a:hover, .sidebar a.active { background:#dc3545; color:#fff; }
        .content { padding:1.5rem; }
        .card { border:0; border-radius:1rem; box-shadow:0 .6rem 1.4rem rgba(15, 23, 42, .08); }
        .table-card { border-radius:1.25rem; min-height:150px; transition:.2s ease; }
        .table-card:hover { transform:translateY(-2px); }
        .table-available { background:#e9f8ef; border:1px solid #badbcc; }
        .table-occupied { background:#fff3cd; border:1px solid #ffecb5; }
        .table-ready { background:#fde2e2; border:1px solid #f5b5b5; animation:pulseReady 1.6s infinite; }
        .table-payment { background:#e7f1ff; border:1px solid #b6d4fe; }
        .table-muted { background:#f1f3f5; border:1px solid #dee2e6; }
        @keyframes pulseReady { 0%{box-shadow:0 0 0 0 rgba(220,53,69,.35)} 70%{box-shadow:0 0 0 .7rem rgba(220,53,69,0)} 100%{box-shadow:0 0 0 0 rgba(220,53,69,0)} }
        .badge-soft { background:#eef2ff; color:#29377a; }
        .dish-img { width:70px; height:70px; object-fit:cover; border-radius:.8rem; background:#e9ecef; }
        @media (max-width: 900px) { .app-shell { grid-template-columns: 1fr; } .sidebar { position:static; } }
    </style>
</head>
<body>
    <div class="app-shell">
        @include('layouts.sidebar')
        <main>
            @include('layouts.navbar')
            <section class="content">
                @include('partials.alerts')
                @yield('content')
            </section>
        </main>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    @yield('scripts')
</body>
</html>

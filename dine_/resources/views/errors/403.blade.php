<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Acceso Denegado — Dine</title>
    <link rel="stylesheet" href="{{ asset('css/adminlte.min.css') }}">
    <style>
        body { background: linear-gradient(135deg,#1a1a2e,#16213e); min-height:100vh; display:flex; align-items:center; justify-content:center; font-family:'Segoe UI',sans-serif; }
        .box { background:#fff; border-radius:20px; padding:3rem; max-width:480px; text-align:center; box-shadow:0 20px 60px rgba(0,0,0,.4); }
        .icon { font-size:4rem; }
        h1 { font-size:1.8rem; font-weight:700; color:#c0392b; }
    </style>
</head>
<body>
<div class="box">
    <div class="icon">🚫</div>
    <h1>Acceso Denegado</h1>
    <p class="text-muted">No tienes permiso para acceder a esta sección.<br>Contacta al administrador si crees que es un error.</p>
    <a href="{{ route('dashboard') }}" class="btn btn-danger mt-2">← Volver al Dashboard</a>
</div>
</body>
</html>

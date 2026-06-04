<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Iniciar sesión | Dine</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { min-height:100vh; display:grid; place-items:center; background:linear-gradient(135deg,#151923,#dc3545); font-family:system-ui,-apple-system,"Segoe UI",sans-serif; }
        .login-card { width:min(440px,92vw); border:0; border-radius:1.5rem; box-shadow:0 1rem 3rem rgba(0,0,0,.25); }
    </style>
</head>
<body>
    <div class="card login-card">
        <div class="card-body p-4 p-md-5">
            <div class="text-center mb-4">
                <div class="fs-1">🍽️</div>
                <h1 class="h3 fw-bold mb-1">Dine Restaurant</h1>
                <p class="text-muted mb-0">Acceso del personal</p>
            </div>

            @if($errors->any())
                <div class="alert alert-danger">
                    {{ $errors->first() }}
                </div>
            @endif

            <form method="POST" action="{{ route('login.post') }}" novalidate>
                @csrf
                <div class="mb-3">
                    <label class="form-label" for="email">Correo</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" class="form-control" required autofocus placeholder="admin@dine.test">
                </div>
                <div class="mb-3">
                    <label class="form-label" for="password">Contraseña</label>
                    <input id="password" type="password" name="password" class="form-control" required placeholder="password">
                </div>
                <div class="form-check mb-4">
                    <input class="form-check-input" type="checkbox" name="remember" id="remember">
                    <label class="form-check-label" for="remember">Recordarme</label>
                </div>
                <button class="btn btn-danger w-100 py-2" type="submit">Ingresar</button>
            </form>

            <div class="small text-muted mt-4 bg-light rounded-3 p-3">
                <strong>Credenciales de prueba</strong><br>
                Administrador: admin@dine.test / password<br>
                Mesero: mesero@dine.test / password
            </div>
        </div>
    </div>
</body>
</html>

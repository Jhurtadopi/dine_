<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Menú digital mesa {{ $table->number }} | Dine</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <style>
        body { background:#fafafa; font-family:system-ui,-apple-system,"Segoe UI",sans-serif; }
        .hero { background:linear-gradient(135deg,#151923,#dc3545); color:#fff; border-radius:0 0 2rem 2rem; padding:2rem 1rem 3rem; }
        .dish-card { border:0; border-radius:1.2rem; box-shadow:0 .4rem 1.2rem rgba(15,23,42,.08); }
        .sticky-cart { position:sticky; top:1rem; }
        .cart-box { border:0; border-radius:1.2rem; box-shadow:0 .4rem 1.2rem rgba(15,23,42,.1); }
        .dish-img { width:82px; height:82px; object-fit:cover; border-radius:1rem; background:#e9ecef; }
    </style>
</head>
<body>
    <header class="hero mb-4">
        <div class="container">
            <div class="d-flex justify-content-between align-items-start gap-3">
                <div>
                    <div class="small opacity-75">Dine Restaurant</div>
                    <h1 class="fw-bold mb-1">Menú digital</h1>
                    <p class="mb-0">Mesa {{ $table->number }} · {{ $table->capacity }} puestos</p>
                </div>
                <span class="badge text-bg-light text-dark">{{ $table->statusLabel() }}</span>
            </div>
        </div>
    </header>

    <main class="container pb-5">
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif
        @if($errors->any())
            <div class="alert alert-danger">{{ $errors->first() }}</div>
        @endif

        @if($finished)
            <div class="alert alert-danger border-0 rounded-4">
                <strong>Sesión finalizada.</strong> El personal ya ve esta mesa como “Cliente listo” en el mapa visual.
            </div>
        @endif

        <div class="row g-4 align-items-start">
            <div class="col-lg-8">
                <div class="alert alert-light border rounded-4">
                    Solo aparecen platos disponibles. Los platos marcados como <strong>Agotado</strong> por el administrador se ocultan automáticamente.
                </div>

                @forelse($categories as $category)
                    <section class="mb-4">
                        <h2 class="h4 fw-bold mb-3">{{ $category->name }}</h2>
                        <div class="vstack gap-3">
                            @foreach($category->dishes as $dish)
                                <div class="card dish-card">
                                    <div class="card-body">
                                        <div class="d-flex gap-3">
                                            @if($dish->image)
                                                <img class="dish-img" src="{{ asset('storage/' . $dish->image) }}" alt="{{ $dish->name }}">
                                            @else
                                                <div class="dish-img d-flex align-items-center justify-content-center text-muted">🍽️</div>
                                            @endif
                                            <div class="flex-grow-1">
                                                <div class="d-flex justify-content-between gap-3">
                                                    <h3 class="h5 fw-bold mb-1">{{ $dish->name }}</h3>
                                                    <div class="fw-bold text-danger text-nowrap">${{ number_format($dish->price, 0, ',', '.') }}</div>
                                                </div>
                                                <p class="text-muted small mb-3">{{ $dish->description ?: 'Sin descripción.' }}</p>
                                                <form method="POST" action="{{ route('guest.cart.add', [$table->qr_token, $dish]) }}" class="d-flex gap-2 align-items-center">
                                                    @csrf
                                                    <input type="number" class="form-control form-control-sm" style="max-width:90px" name="quantity" value="1" min="1" max="20" aria-label="Cantidad">
                                                    <button class="btn btn-sm btn-danger" type="submit"><i class="bi bi-cart-plus"></i> Agregar</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </section>
                @empty
                    <div class="card border-0 rounded-4"><div class="card-body text-center py-5 text-muted">No hay platos disponibles por el momento.</div></div>
                @endforelse
            </div>

            <div class="col-lg-4">
                <aside class="sticky-cart">
                    <div class="card cart-box">
                        <div class="card-body">
                            <h2 class="h5 fw-bold mb-3"><i class="bi bi-cart3"></i> Carrito de pre-pedido</h2>

                            @if(count($cart))
                                <div class="vstack gap-3">
                                    @foreach($cart as $item)
                                        <div class="border-bottom pb-3">
                                            <div class="d-flex justify-content-between gap-2">
                                                <div>
                                                    <div class="fw-semibold">{{ $item['name'] }}</div>
                                                    <div class="small text-muted">${{ number_format($item['price'], 0, ',', '.') }} c/u</div>
                                                </div>
                                                <div class="fw-bold">${{ number_format($item['price'] * $item['quantity'], 0, ',', '.') }}</div>
                                            </div>
                                            <div class="d-flex gap-2 mt-2">
                                                <form method="POST" action="{{ route('guest.cart.update', [$table->qr_token, $item['dish_id']]) }}" class="d-flex gap-2">
                                                    @csrf
                                                    @method('PATCH')
                                                    <input type="number" class="form-control form-control-sm" name="quantity" value="{{ $item['quantity'] }}" min="1" max="20" style="max-width:80px">
                                                    <button class="btn btn-sm btn-outline-dark">Actualizar</button>
                                                </form>
                                                <form method="POST" action="{{ route('guest.cart.remove', [$table->qr_token, $item['dish_id']]) }}">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button class="btn btn-sm btn-outline-danger" aria-label="Retirar {{ $item['name'] }}"><i class="bi bi-trash"></i></button>
                                                </form>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>

                                <div class="d-flex justify-content-between align-items-center mt-3 h5">
                                    <span>Total</span>
                                    <strong>${{ number_format($cartTotal, 0, ',', '.') }}</strong>
                                </div>

                                <div class="alert alert-warning small mt-3 mb-3">
                                    Este es un <strong>pre-pedido</strong>. No se envía a cocina sin validación del mesero.
                                </div>
                            @else
                                <p class="text-muted">Aún no has agregado platos.</p>
                                <div class="alert alert-warning small mb-3">
                                    Este carrito sirve para elegir con calma. El pedido no se envía a cocina sin validación del mesero.
                                </div>
                            @endif

                            <form method="POST" action="{{ route('guest.finish', $table->qr_token) }}" onsubmit="return confirm('¿Finalizar la sesión del menú digital?')">
                                @csrf
                                <button class="btn btn-danger w-100" type="submit">
                                    <i class="bi bi-check2-circle"></i> Finalizar sesión y avisar al personal
                                </button>
                            </form>
                        </div>
                    </div>
                </aside>
            </div>
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

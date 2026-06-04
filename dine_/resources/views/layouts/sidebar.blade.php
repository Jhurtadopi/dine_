<aside class="sidebar">
    <div class="d-flex align-items-center gap-2 mb-4">
        <div class="fs-2">🍽️</div>
        <div>
            <div class="fw-bold fs-4">Dine</div>
            <div class="small text-white-50">Incremento entregable</div>
        </div>
    </div>

    @auth
        <div class="border border-secondary rounded-4 p-3 mb-4">
            <div class="small text-white-50">Usuario activo</div>
            <div class="fw-semibold">{{ auth()->user()->name }}</div>
            <span class="badge text-bg-danger mt-2">{{ auth()->user()->role->name ?? 'Sin rol' }}</span>
        </div>
    @endauth

    <nav>
        @if(auth()->user()->isAdmin() || auth()->user()->isWaiter())
            <a href="{{ route('tables.index') }}" class="{{ request()->routeIs('tables.*') ? 'active' : '' }}">
                <i class="bi bi-grid-3x3-gap-fill"></i> Mapa de mesas
            </a>
        @endif

        @if(auth()->user()->isAdmin())
            <a href="{{ route('dishes.index') }}" class="{{ request()->routeIs('dishes.*') ? 'active' : '' }}">
                <i class="bi bi-cup-hot-fill"></i> Platos
            </a>
            <a href="{{ route('categories.index') }}" class="{{ request()->routeIs('categories.*') ? 'active' : '' }}">
                <i class="bi bi-tags-fill"></i> Categorías
            </a>
        @endif
    </nav>
</aside>

<nav class="navbar navbar-expand bg-white border-bottom px-4 py-3">
    <div class="container-fluid px-0">
        <span class="navbar-brand mb-0 h5">@yield('page-title', 'Panel Dine')</span>
        <div class="d-flex align-items-center gap-3">
            @auth
                <span class="text-muted small">{{ auth()->user()->name }} · {{ auth()->user()->role->name ?? 'Sin rol' }}</span>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="btn btn-outline-danger btn-sm" type="submit">Cerrar sesión</button>
                </form>
            @endauth
        </div>
    </div>
</nav>

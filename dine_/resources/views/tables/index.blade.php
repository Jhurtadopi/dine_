@extends('layouts.app')

@section('title', 'Mapa de mesas | Dine')
@section('page-title', 'Mapa visual de mesas')

@section('content')
<div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
    <div>
        <h1 class="h3 fw-bold mb-1">Mapa visual de mesas</h1>
        <p class="text-muted mb-0">Consulta el estado del salón. La información se actualiza automáticamente.</p>
    </div>
    @if(auth()->user()->isAdmin())
        <a href="{{ route('tables.create') }}" class="btn btn-danger">
            <i class="bi bi-plus-circle"></i> Nueva mesa
        </a>
    @endif
</div>

<div class="row g-3 mb-4">
    <div class="col-md-3"><div class="card table-available"><div class="card-body"><strong>Disponible</strong><div class="small text-muted">Mesa libre</div></div></div></div>
    <div class="col-md-3"><div class="card table-occupied"><div class="card-body"><strong>Ocupada</strong><div class="small text-muted">Cliente en sesión</div></div></div></div>
    <div class="col-md-3"><div class="card table-ready"><div class="card-body"><strong>Cliente listo</strong><div class="small text-muted">Indicador de atención</div></div></div></div>
    <div class="col-md-3"><div class="card table-payment"><div class="card-body"><strong>Pendiente de pago</strong><div class="small text-muted">Cierre pendiente</div></div></div></div>
</div>

<div id="tables-map" class="row g-4">
    @foreach($tables as $table)
        @include('tables.partials.table-card', ['table' => $table])
    @endforeach
</div>
@endsection

@section('scripts')
<script>
    const statusFeedUrl = @json(route('tables.statusFeed'));
    const isAdmin = @json(auth()->user()->isAdmin());

    function renderTable(table) {
        const adminActions = isAdmin ? `
            <div class="d-flex gap-2 mt-3">
                <a class="btn btn-sm btn-outline-dark" href="/tables/${table.id}/edit">Editar</a>
                <a class="btn btn-sm btn-outline-primary" href="/tables/${table.id}">QR</a>
            </div>` : `
            <a class="btn btn-sm btn-outline-primary mt-3" href="/tables/${table.id}">Ver QR</a>`;

        return `
            <div class="col-sm-6 col-xl-3" data-table-id="${table.id}">
                <div class="card table-card ${table.status_class}">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <div class="text-muted small">Mesa</div>
                                <div class="display-6 fw-bold">${table.number}</div>
                            </div>
                            <span class="badge bg-dark-subtle text-dark">${table.capacity} puestos</span>
                        </div>
                        <div class="mt-3 fw-semibold">${table.status_label}</div>
                        ${table.status === 'ready_for_service' ? '<div class="small text-danger fw-semibold mt-1">El cliente finalizó la sesión del menú digital.</div>' : ''}
                        ${adminActions}
                    </div>
                </div>
            </div>`;
    }

    async function refreshTables() {
        try {
            const response = await fetch(statusFeedUrl, { headers: { 'Accept': 'application/json' } });
            if (!response.ok) return;
            const tables = await response.json();
            document.getElementById('tables-map').innerHTML = tables.map(renderTable).join('');
        } catch (error) {
            console.warn('No se pudo actualizar el mapa de mesas', error);
        }
    }

    setInterval(refreshTables, 5000);
</script>
@endsection

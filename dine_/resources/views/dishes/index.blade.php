@extends('layouts.app')
@section('title', 'Platos | Dine')
@section('page-title', 'Gestión de platos')
@section('content')
<div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
    <div>
        <h1 class="h3 fw-bold mb-1">Platos del menú digital</h1>
        <p class="text-muted mb-0">Crea, edita, elimina y marca platos como agotados.</p>
    </div>
    <a href="{{ route('dishes.create') }}" class="btn btn-danger"><i class="bi bi-plus-circle"></i> Nuevo plato</a>
</div>

<div class="card">
    <div class="table-responsive">
        <table class="table align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th>Plato</th>
                    <th>Categoría</th>
                    <th>Precio</th>
                    <th>Estado</th>
                    <th class="text-end">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($dishes as $dish)
                    <tr>
                        <td>
                            <div class="d-flex align-items-center gap-3">
                                @if($dish->image)
                                    <img class="dish-img" src="{{ asset('storage/' . $dish->image) }}" alt="{{ $dish->name }}">
                                @else
                                    <div class="dish-img d-grid place-items-center"></div>
                                @endif
                                <div>
                                    <div class="fw-semibold">{{ $dish->name }}</div>
                                    <div class="small text-muted">{{ \Illuminate\Support\Str::limit($dish->description, 70) }}</div>
                                </div>
                            </div>
                        </td>
                        <td>{{ $dish->category->name ?? 'Sin categoría' }}</td>
                        <td>${{ number_format($dish->price, 0, ',', '.') }}</td>
                        <td>
                            <span class="badge {{ $dish->available ? 'text-bg-success' : 'text-bg-danger' }}">{{ $dish->statusLabel() }}</span>
                        </td>
                        <td class="text-end">
                            <a class="btn btn-sm btn-outline-primary" href="{{ route('dishes.show', $dish) }}">Ver</a>
                            <a class="btn btn-sm btn-outline-dark" href="{{ route('dishes.edit', $dish) }}">Editar</a>
                            <form method="POST" action="{{ route('dishes.toggleAvailability', $dish) }}" class="d-inline">
                                @csrf
                                @method('PATCH')
                                <button class="btn btn-sm {{ $dish->available ? 'btn-outline-warning' : 'btn-outline-success' }}">
                                    {{ $dish->available ? 'Agotar' : 'Reactivar' }}
                                </button>
                            </form>
                            <form method="POST" action="{{ route('dishes.destroy', $dish) }}" class="d-inline" onsubmit="return confirm('¿Eliminar este plato?')">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="text-center text-muted py-4">No hay platos registrados.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection

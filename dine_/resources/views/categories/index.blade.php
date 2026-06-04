@extends('layouts.app')
@section('title', 'Categorías | Dine')
@section('page-title', 'Categorías')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h3 fw-bold mb-1">Categorías del menú</h1>
        <p class="text-muted mb-0">Agrupa los platos que ve el comensal en el menú digital.</p>
    </div>
    <a href="{{ route('categories.create') }}" class="btn btn-danger"><i class="bi bi-plus-circle"></i> Nueva categoría</a>
</div>

<div class="card">
    <div class="table-responsive">
        <table class="table align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th>Nombre</th>
                    <th>Descripción</th>
                    <th>Platos</th>
                    <th class="text-end">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($categories as $category)
                    <tr>
                        <td class="fw-semibold">{{ $category->name }}</td>
                        <td>{{ $category->description ?: 'Sin descripción' }}</td>
                        <td><span class="badge badge-soft">{{ $category->dishes_count }}</span></td>
                        <td class="text-end">
                            <a class="btn btn-sm btn-outline-dark" href="{{ route('categories.edit', $category) }}">Editar</a>
                            <form method="POST" action="{{ route('categories.destroy', $category) }}" class="d-inline" onsubmit="return confirm('¿Eliminar esta categoría?')">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="4" class="text-center text-muted py-4">No hay categorías registradas.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection

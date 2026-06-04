@extends('layouts.app')
@section('title', 'Detalle de plato | Dine')
@section('page-title', 'Detalle de plato')
@section('content')
<div class="card">
    <div class="card-body">
        <div class="row g-4 align-items-start">
            <div class="col-md-4">
                @if($dish->image)
                    <img class="img-fluid rounded-4" src="{{ asset('storage/' . $dish->image) }}" alt="{{ $dish->name }}">
                @else
                    <div class="bg-light rounded-4 d-grid place-items-center" style="height:260px;"><span class="text-muted">Sin imagen</span></div>
                @endif
            </div>
            <div class="col-md-8">
                <span class="badge {{ $dish->available ? 'text-bg-success' : 'text-bg-danger' }} mb-3">{{ $dish->statusLabel() }}</span>
                <h1 class="h3 fw-bold">{{ $dish->name }}</h1>
                <p class="text-muted">{{ $dish->category->name ?? 'Sin categoría' }}</p>
                <p>{{ $dish->description ?: 'Sin descripción.' }}</p>
                <div class="h4 fw-bold text-danger">${{ number_format($dish->price, 0, ',', '.') }}</div>
                <div class="d-flex gap-2 mt-4">
                    <a href="{{ route('dishes.edit', $dish) }}" class="btn btn-outline-dark">Editar</a>
                    <a href="{{ route('dishes.index') }}" class="btn btn-danger">Volver</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@extends('layouts.app')
@section('title', 'QR de mesa | Dine')
@section('page-title', 'QR de mesa')
@section('content')
@php($menuUrl = route('guest.menu', $table->qr_token))
<div class="row g-4">
    <div class="col-lg-5">
        <div class="card">
            <div class="card-body text-center">
                <h1 class="h4 fw-bold">Mesa {{ $table->number }}</h1>
                <p class="text-muted">Capacidad: {{ $table->capacity }} personas · Estado: {{ $table->statusLabel() }}</p>
                <img class="img-fluid border rounded-4 p-2 bg-white" alt="QR mesa {{ $table->number }}" src="https://api.qrserver.com/v1/create-qr-code/?size=240x240&data={{ urlencode($menuUrl) }}">
                <div class="small text-muted mt-3">URL codificada:</div>
                <a href="{{ $menuUrl }}" target="_blank" class="text-break">{{ $menuUrl }}</a>
                <div class="d-print-none mt-4 d-flex justify-content-center gap-2">
                    <button onclick="window.print()" class="btn btn-outline-dark">Imprimir QR</button>
                    <a href="{{ route('tables.index') }}" class="btn btn-danger">Volver al mapa</a>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-7">
        <div class="card">
            <div class="card-body">
                <h2 class="h5 fw-bold">Cumplimiento de la historia de usuario</h2>
                <p class="mb-2">Cada mesa tiene un token único y un enlace directo al menú digital de esa mesa.</p>
                <p class="mb-0 text-muted">Al escanear el QR, el comensal entra al menú público, puede armar su carrito de pre-pedido y finalizar la sesión para activar el indicador “Cliente listo” en el mapa.</p>
            </div>
        </div>
    </div>
</div>
@endsection

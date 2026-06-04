@extends('layouts.app')
@section('title', 'Nuevo plato | Dine')
@section('page-title', 'Nuevo plato')
@section('content')
<div class="card"><div class="card-body">
    <h1 class="h4 fw-bold mb-4">Registrar plato</h1>
    <form method="POST" action="{{ route('dishes.store') }}" enctype="multipart/form-data">
        @csrf
        @include('dishes.partials.form', ['dish' => new \App\Models\Dish(['available' => true]), 'categories' => $categories])
    </form>
</div></div>
@endsection

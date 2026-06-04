@extends('layouts.app')
@section('title', 'Editar plato | Dine')
@section('page-title', 'Editar plato')
@section('content')
<div class="card"><div class="card-body">
    <h1 class="h4 fw-bold mb-4">Editar plato</h1>
    <form method="POST" action="{{ route('dishes.update', $dish) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        @include('dishes.partials.form', ['dish' => $dish, 'categories' => $categories])
    </form>
</div></div>
@endsection

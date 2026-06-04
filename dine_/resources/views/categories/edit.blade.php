@extends('layouts.app')
@section('title', 'Editar categoría | Dine')
@section('page-title', 'Editar categoría')
@section('content')
<div class="card"><div class="card-body">
    <h1 class="h4 fw-bold mb-4">Editar categoría</h1>
    <form method="POST" action="{{ route('categories.update', $category) }}">
        @csrf
        @method('PUT')
        @include('categories.partials.form', ['category' => $category])
    </form>
</div></div>
@endsection

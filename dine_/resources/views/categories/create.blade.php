@extends('layouts.app')
@section('title', 'Nueva categoría | Dine')
@section('page-title', 'Nueva categoría')
@section('content')
<div class="card"><div class="card-body">
    <h1 class="h4 fw-bold mb-4">Registrar categoría</h1>
    <form method="POST" action="{{ route('categories.store') }}">
        @csrf
        @include('categories.partials.form', ['category' => new \App\Models\Category()])
    </form>
</div></div>
@endsection

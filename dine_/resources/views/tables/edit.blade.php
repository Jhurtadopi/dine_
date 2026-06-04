@extends('layouts.app')
@section('title', 'Editar mesa | Dine')
@section('page-title', 'Editar mesa')
@section('content')
<div class="card">
    <div class="card-body">
        <h1 class="h4 fw-bold mb-4">Editar mesa {{ $table->number }}</h1>
        <form method="POST" action="{{ route('tables.update', $table) }}">
            @csrf
            @method('PUT')
            @include('tables.partials.form', ['table' => $table])
        </form>
    </div>
</div>
@endsection

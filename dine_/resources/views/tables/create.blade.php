@extends('layouts.app')
@section('title', 'Nueva mesa | Dine')
@section('page-title', 'Registrar mesa')
@section('content')
<div class="card">
    <div class="card-body">
        <h1 class="h4 fw-bold mb-4">Nueva mesa</h1>
        <form method="POST" action="{{ route('tables.store') }}">
            @csrf
            @include('tables.partials.form', ['table' => $table])
        </form>
    </div>
</div>
@endsection

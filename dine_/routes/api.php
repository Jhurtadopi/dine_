<?php

use Illuminate\Support\Facades\Route;

// Este incremento no expone API pública. La interacción del mapa se atiende desde web.php
// con la ruta autenticada /mesas/estado-json.
Route::get('/health', fn () => ['status' => 'ok'])->name('api.health');

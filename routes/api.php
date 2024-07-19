<?php

use App\Http\Controllers\PersonaController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {
    Route::post('/alta', [PersonaController::class, 'alta'])->name('alta');
    Route::get('/listar', [PersonaController::class, 'listar'])->name('listar');
    Route::get('/buscar/{id}', [PersonaController::class, 'buscar'])->name('buscar');
    Route::delete('/eliminar/{id}', [PersonaController::class, 'eliminar'])->name('eliminar');
});
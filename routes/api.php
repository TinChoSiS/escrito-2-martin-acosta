<?php

use App\Http\Controllers\PersonaController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {
    Route::post('/alta', [PersonaController::class, 'alta'])->name('alta');
    Route::get('/listar', [PersonaController::class, 'listar'])->name('listar');
});
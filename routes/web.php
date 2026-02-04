<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Provider\ProviderDashboardController;
use App\Http\Controllers\Provider\ProviderPatientController;

Route::middleware(['auth', 'role:provider', 'active.provider'])
    ->prefix('provider')
    ->name('provider.')
    ->group(function () {

        Route::get('/dashboard', [ProviderDashboardController::class, 'index'])
            ->name('dashboard');



        Route::post('/patients', [ProviderPatientController::class, 'store'])
            ->name('patients.store');
    });



require __DIR__ . '/auth.php';

<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Provider\ProviderDashboardController;
use App\Http\Controllers\Provider\ProviderPatientController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AdminProviderController;

Route::middleware(['auth', 'role:provider', 'active.provider'])
    ->prefix('provider')
    ->name('provider.')
    ->group(function () {

        Route::get('/dashboard', [ProviderDashboardController::class, 'index'])
            ->name('dashboard');



        Route::post('/patients', [ProviderPatientController::class, 'store'])
            ->name('patients.store');
    });


Route::middleware(['auth', 'role:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        Route::get('/dashboard', [AdminDashboardController::class, 'index'])
            ->name('dashboard');

        Route::get('/providers', [AdminProviderController::class, 'index'])
            ->name('providers.index');

        Route::post('/providers', [AdminProviderController::class, 'store'])
            ->name('providers.store');
    });


require __DIR__ . '/auth.php';

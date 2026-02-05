<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Provider\ProviderDashboardController;
use App\Http\Controllers\Provider\ProviderPatientController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AdminProviderController;
use App\Http\Controllers\LocaleController;
use App\Http\Controllers\RootController;
use App\Http\Controllers\Admin\AdminPatientController;


Route::get('/', RootController::class)->name('root');
Route::get('/lang/{lang}', [LocaleController::class, 'switch'])->name('lang.switch');

Route::middleware(['auth'])
    ->group(function () {
        Route::get('/perfil', [ProfileController::class, 'index'])->name('profile.index');
        Route::post('/perfil/actualizar', [ProfileController::class, 'update'])->name('profile.update');
        Route::post('/perfil/foto', [ProfileController::class, 'updatePhoto'])->name('profile.update.photo');
        Route::post('/perfil/password', [ProfileController::class, 'updatePassword'])->name('profile.update.password');
    });



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

        Route::put('/patients/{patient}/status', [AdminPatientController::class, 'updateStatus']);
        Route::get('/patients/{patient}', [AdminPatientController::class, 'show']);
        // routes/web.php
        Route::post('/patients', [AdminPatientController::class, 'store'])->name('patients.store');

        Route::patch('/providers/{provider}/status', [AdminProviderController::class, 'updateStatus'])->name('providers.status');


    });





require __DIR__ . '/auth.php';

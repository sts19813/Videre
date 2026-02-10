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
use App\Http\Controllers\Admin\AdminUserController;

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
        Route::get('/dashboard', [ProviderDashboardController::class, 'index'])->name('dashboard');
        Route::post('/patients', [ProviderPatientController::class, 'store'])->name('patients.store');
        Route::get('patients/{patient}', [ProviderPatientController::class, 'show'])->name('patients.show');
    });


Route::middleware(['auth', 'role:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
        Route::get('/providers', [AdminProviderController::class, 'index'])->name('providers.index');
        Route::post('/providers', [AdminProviderController::class, 'store'])->name('providers.store');
        Route::post('/patients', [AdminPatientController::class, 'store'])->name('patients.store');
        Route::get('/patients/{patient}', [AdminPatientController::class, 'show'])->name('patients.show');
        Route::put('/patients/{patient}/status', [AdminPatientController::class, 'updateStatus'])->name('patients.status');
        Route::put('/providers/{provider}/status', [AdminProviderController::class, 'updateStatus'])->name('providers.status');
        Route::put('/patients/{patient}/schedule', [AdminPatientController::class, 'schedule'])->name('patients.schedule');
        Route::put('/patients/{patient}/attend', [AdminPatientController::class, 'attend'])->name('patients.attend');
        Route::put('/patients/{patient}/cancel', [AdminPatientController::class, 'cancel'])->name('patients.cancel');

        Route::get('/providers/{provider}', [AdminProviderController::class, 'show'])->name('admin.providers.show');

        Route::post('/users', [AdminUserController::class, 'store'])->name('admin.users.store');
        Route::patch('/users/{user}/disable', [AdminUserController::class, 'disable'])->name('admin.users.disable');
    });


require __DIR__ . '/auth.php';

<?php

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\InstructionController;





Route::prefix('admin')->group(function () {
    Route::get('login', [AdminAuthController::class, 'showLoginForm'])->name('admin.login');
    Route::post('login', [AdminAuthController::class, 'login'])->name('admin.login.submit');
    Route::post('logout', [AdminAuthController::class, 'logout'])->name('admin.logout');
});

Route::prefix('admin')->middleware(['auth:admin-web'])->group(function () {
    Route::get('/admin/profile', [AdminController::class, 'profile'])->name('admin.profile');
    Route::put('/admin/profile', [AdminController::class, 'updateProfile'])->name('admin.profile.update');
    Route::get('/index', [AdminController::class, 'index'])->name('admin.index');
    Route::get('/instructions', [InstructionController::class, 'index'])->name('admin.instructions');
    Route::post('/instructions', [InstructionController::class, 'store'])->name('admin.instructions.store');
    Route::get('/instructions/{id}/edit', [InstructionController::class, 'edit'])->name('admin.instructions.edit');
    Route::put('/instructions/{id}', [InstructionController::class, 'update'])->name('admin.instructions.update');
    Route::delete('/instructions/{id}', [InstructionController::class, 'destroy'])->name('admin.instructions.delete');
    
    Route::get('/shelters', [AdminController::class, 'shelters'])->name('admin.shelters');
    Route::post('/shelters', [AdminController::class, 'storeShelter'])->name('admin.shelters.store');
    Route::get('/shelters/{id}/edit', [AdminController::class, 'editShelter'])->name('admin.shelters.edit');
    Route::put('/shelters/{id}', [AdminController::class, 'updateShelter'])->name('admin.shelters.update');
    Route::delete('/shelters/{id}', [AdminController::class, 'deleteShelter'])->name('admin.shelters.delete');

    Route::get('/veterinary', [AdminController::class, 'veterinary'])->name('admin.veterinary');
    Route::post('/veterinary', [AdminController::class, 'storeVeterinaryCenter'])->name('admin.veterinary.store');
    Route::get('/veterinary/{id}/edit', [AdminController::class, 'editVeterinaryCenter'])->name('admin.veterinary.edit');
    Route::put('/veterinary/{id}', [AdminController::class, 'updateVeterinaryCenter'])->name('admin.veterinary.update');
    Route::delete('/veterinary/{id}', [AdminController::class, 'deleteVeterinaryCenter'])->name('admin.veterinary.delete');
});
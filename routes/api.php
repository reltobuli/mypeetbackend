<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PetownerController;
use App\Http\Controllers\AdoptionController;
use App\Http\Controllers\MissingPetController; // Corrected controller reference
use App\Http\Controllers\PetController;
use App\Http\Controllers\QRCodeController;
use App\Http\Controllers\InformationController;
use App\Http\Controllers\InstructionController;

// Instruction Routes
Route::get('/api/instructions', [InstructionController::class, 'index']);
Route::get('/qrcode', [QRCodeController::class, 'generate']);
Route::get('/pets/{id}', [PetController::class, 'show'])->name('pets.show');

// Petowner Routes
Route::group(['prefix' => 'Petowner'], function () {
    Route::post('register', [AuthController::class, 'register']);
    Route::post('login', [AuthController::class, 'login']);

    Route::group(['middleware' => ['auth:Petowner-api']], function () {
        Route::post('logout', [AuthController::class, 'logout']);
        Route::get('profile', [PetownerController::class, 'profile']); // Route to fetch profile
        Route::put('profile/update', [PetownerController::class, 'update']); // Route to update profile
        Route::post('add-pet', [PetownerController::class, 'addPet']);
        Route::post('report-missing-pet', [MissingPetController::class, 'reportMissingPet']); // Corrected controller reference
    });

    // Adoption Routes
    Route::get('adoptions', [AdoptionController::class, 'index']);
    Route::post('adoptions/{id}/request', [AdoptionController::class, 'requestAdoption']);
    Route::post('adoptions/{id}/approve', [AdoptionController::class, 'approveAdoption']);
    Route::post('adoptions/{id}/reject', [AdoptionController::class, 'rejectAdoption']);
});

// Pet Routes
Route::middleware('auth:sanctum')->group(function () {
    Route::get('pets', [PetController::class, 'index']);
    Route::get('/pets/{id}', [PetController::class, 'show'])->name('pets.show');
    Route::post('pets', [PetController::class, 'store']);
    Route::put('pets/{id}', [PetController::class, 'update']);
    Route::delete('pets/{id}', [PetController::class, 'destroy']);
    Route::post('pets/{id}/report-missing', [PetController::class, 'reportMissing']);
    Route::post('pets/{id}/give-up', [PetController::class, 'giveUpPet']);
});

// Report Routes
Route::post('report/found-pet', [MissingPetController::class, 'reportFoundPet']); // Corrected controller reference
Route::post('report/scan-tag', [MissingPetController::class, 'scanTag']); // Corrected controller reference
Route::post('report/search-missing-pets', [MissingPetController::class, 'searchMissingPets']); // Corrected controller reference

// Information Routes
Route::get('shelters', [InformationController::class, 'listShelters']);
Route::get('veterinaries', [InformationController::class, 'listVeterinaries']);

// Fallback Route
Route::fallback(function () {
    return response()->json(['message' => 'Not Found.'], 404);
});

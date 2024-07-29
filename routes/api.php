<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PetownerController;
use App\Http\Controllers\MissingPetController; // Corrected controller reference
use App\Http\Controllers\PetController;
use App\Http\Controllers\QrCodeController;
use App\Http\Controllers\InformationController;
use App\Http\Controllers\InstructionController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\PetIDController;
use App\Http\Controllers\AdoptionController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

// Existing API routes...

Route::middleware('auth:Petowner-api')->get('/notifications', function () {
    return Auth::user()->notifications;
});

// Public Routes
Route::get('/pets/adoptable', [PetController::class, 'getAdoptablePets']);
Route::get('/missing-pets', [MissingPetController::class, 'index']);
Route::get('instructions', [InstructionController::class, 'showInstructions']);
Route::get('/qrcode', [QrCodeController::class, 'generate']);
Route::get('shelters', [InformationController::class, 'listShelters']);
Route::get('veterinaries', [InformationController::class, 'listVeterinaries']);

Route::middleware('auth:Petowner-api')->get('/pets/user', [PetController::class, 'getPetsForCurrentUser']);

// Petowner Routes
Route::group(['prefix' => 'Petowner'], function () {
    Route::post('register', [AuthController::class, 'register']);
    Route::post('login', [AuthController::class, 'login']);

    Route::group(['middleware' => ['auth:Petowner-api']], function () {
        Route::post('logout', [AuthController::class, 'logout']);
        Route::get('profile', [PetownerController::class, 'profile']); // Route to fetch profile
        Route::put('profile/update', [PetownerController::class, 'updateProfile']); // Route to update profile
        Route::post('add-pet', [PetownerController::class, 'addPet']);
        Route::post('report-missing-pet', [MissingPetController::class, 'reportMissingPet']);
        Route::get('/notifications', [NotificationController::class, 'index']);
        Route::post('pets', [PetController::class, 'store']);
        Route::get('pets/user/{userId}', [PetController::class, 'getPetByUserId']);
        Route::get('/pets', [PetController::class, 'getPets']);
        Route::post('/pets/profile/update/{id}', [PetController::class, 'update']);
        Route::get('pets/{id}', [PetController::class, 'show'])->name('pets.show');
        Route::post('/pets/{id}/give-up', [PetController::class, 'giveUpPet']);
        Route::post('/pets/{id}/request-adoption', [PetController::class, 'requestAdoption']); // Add this line
        Route::get('/user/notifications', [NotificationController::class, 'Notifications']);
        Route::post('/adoption-requests/{adoptionRequestId}/accept', [AdoptionController::class, 'accept']);
        Route::post('/adoption-requests/{adoptionRequestId}/reject', [AdoptionController::class, 'reject']);
     
        
        Route::get('/petowner/notifications', [PetownerController::class, 'notifications']);
    });
});

// Pet Routes

// Report Routes
Route::post('report/found-pet', [MissingPetController::class, 'reportFoundPet']); // Corrected controller reference
Route::post('report/scan-tag', [MissingPetController::class, 'scanTag']); // Corrected controller reference
Route::post('report/search-missing-pets', [MissingPetController::class, 'searchMissingPets']); // Corrected controller reference

// Fallback Route
Route::fallback(function () {
    return response()->json(['message' => 'Not Found.'], 404);
});
<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API;
use App\Http\Controllers\API\AuthController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// require __DIR__.'/api/v1.php';

// Public routes
Route::post('register', [AuthController::class, 'register']);
// Route::post('login', [AuthController::class, 'login']);

Route::post('login', [AuthController::class, 'login']);

Route::middleware('auth:api')->group(function () {

    // packages
    Route::apiResource('packages', API\PackageController::class);

    // Equipment
    Route::apiResource('equipment',  API\EquipmentController::class);
  
    // users
    Route::post('users', [API\UserController::class, 'create']); // Create a user
    Route::get('users', [API\UserController::class, 'index']); // Retrieve all users
    Route::get('users/{id}', [API\UserController::class, 'show']); // Retrieve a user
    Route::put('users/{id}', [API\UserController::class, 'update']); // Update a user
    Route::delete('users/{id}', [API\UserController::class, 'destroy']); // Delete a user

    // Payment Mode
    Route::get('payment-modes', [API\PaymentModeController::class, 'index']);
    Route::post('payment-modes', [API\PaymentModeController::class, 'store']);
    Route::get('payment-modes/{id}', [API\PaymentModeController::class, 'show']);
    Route::put('payment-modes/{id}', [API\PaymentModeController::class, 'update']);
    Route::delete('payment-modes/{id}', [API\PaymentModeController::class, 'destroy']);


    Route::post('/logout', [AuthController::class, 'logout']);
});


/* Fallback */
Route::fallback(function(){
    return response()->json([
        'message' => 'Page Not Found. If error persists, contact shaileshdhandhukiya012@gmail.com'], 404);
});
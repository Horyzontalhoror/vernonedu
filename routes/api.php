<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ProgramController;
use App\Http\Controllers\Api\JadwalController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\TransactionController;

/*
|--------------------------------------------------------------------------
| PUBLIC ROUTES (tidak perlu login)
|--------------------------------------------------------------------------
*/

Route::get('/courses', function () {
    return [
        ['id'=>1,'title'=>'Public Speaking'],
        ['id'=>2,'title'=>'Entrepreneurship']
    ];
});

Route::get('/programs', [ProgramController::class, 'index']);
Route::get('/programs/{id}/sub-programs', [ProgramController::class, 'subPrograms']);
Route::get('/sub-programs/{slug}', [ProgramController::class, 'showSubProgram']);

Route::get('/jadwals', [JadwalController::class, 'index']);
Route::get('/jadwals', [JadwalController::class, 'index']); // list
Route::get('/jadwals/calendar', [JadwalController::class, 'calendar']); // calendar

// AUTH
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/me', [AuthController::class, 'me']);
});

// pemabayaran
Route::middleware('auth:sanctum')->post('/create-transaction', [TransactionController::class, 'store']);
Route::post('/midtrans/callback', [TransactionController::class, 'callback']);

/*
|--------------------------------------------------------------------------
| CUSTOM AUTH CHECK (FIX ERROR login route)
|--------------------------------------------------------------------------
*/

Route::get('/me', function (Request $request) {

    // 🔥 cek token manual (hindari redirect login)
    if (!auth('sanctum')->check()) {
        return response()->json([
            'message' => 'Unauthenticated.'
        ], 401);
    }

    return auth('sanctum')->user();

});


/*
|--------------------------------------------------------------------------
| PROTECTED ROUTES (harus login)
|--------------------------------------------------------------------------
*/

Route::middleware('auth:sanctum')->group(function () {

    // contoh: jadwal hanya untuk user login
    // Route::get('/jadwals', [JadwalController::class, 'index']);

    // logout
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/create-transaction', [TransactionController::class, 'createTransaction']);

});

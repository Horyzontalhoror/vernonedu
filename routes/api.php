<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ProgramController;
use App\Http\Controllers\Api\JadwalController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\TransactionController;
use App\Http\Controllers\Api\User\CourseController;
use App\Http\Controllers\Api\User\ScheduleController;
use App\Http\Controllers\Api\AnnouncementController;

/*
|--------------------------------------------------------------------------
| PUBLIC ROUTES (tidak perlu login)
|--------------------------------------------------------------------------
*/

Route::get('/courses', function () {
    return [
        ['id' => 1, 'title' => 'Public Speaking'],
        ['id' => 2, 'title' => 'Entrepreneurship']
    ];
});
Route::get('/announcements', [AnnouncementController::class, 'index']); // pengumuman untuk user dashboard
Route::get('/programs', [ProgramController::class, 'index']);
Route::get('/programs/{id}/sub-programs', [ProgramController::class, 'subPrograms']);
Route::get('/sub-programs/{slug}', [ProgramController::class, 'showSubProgram']);

Route::get('/jadwals', [JadwalController::class, 'index']); // list
Route::get('/jadwals/calendar', [JadwalController::class, 'calendar']); // calendar

/*
|--------------------------------------------------------------------------
| AUTH (PUBLIC)
|--------------------------------------------------------------------------
*/

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

/*
|--------------------------------------------------------------------------
| MIDTRANS CALLBACK (PUBLIC)
|--------------------------------------------------------------------------
*/

Route::post('/midtrans/callback', [TransactionController::class, 'callback']);

/*
|--------------------------------------------------------------------------
| PROTECTED ROUTES (harus login)
|--------------------------------------------------------------------------
*/

Route::middleware('auth:sanctum')->group(function () {

    // 🔐 AUTH USER
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/me', [AuthController::class, 'me']);

    // 💳 TRANSACTION
    Route::post('/create-transaction', [TransactionController::class, 'createTransaction']);
    Route::post('/callback', [TransactionController::class, 'callback']);

    // 🎓 MY COURSES (🔥 INI YANG KAMU BUTUHKAN)
    Route::get('/my-courses', [CourseController::class, 'myCourses']);
    Route::get('/my-schedule', [ScheduleController::class, 'mySchedule']);

});

<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ProgramController;
use App\Http\Controllers\Api\JadwalController;
use App\Http\Controllers\Api\TransactionController;
use App\Http\Controllers\Api\AnnouncementController;

use App\Http\Controllers\Api\User\CertificateController;
use App\Http\Controllers\Api\User\ProfileController;
use App\Http\Controllers\Api\User\CourseController;
use App\Http\Controllers\Api\User\ScheduleController;
use App\Http\Controllers\Api\User\NotificationController;

//tes
use Illuminate\Support\Facades\Mail;

Route::get('/test-mail', function () {

    Mail::raw(

        'Test email VernonEdu',

        function ($message) {

            $message
                ->to('specbr96@gmail.com')
                ->subject('Test Mail VernonEdu');
        }

    );

    return response()->json([
        'message' => 'Mail sent!',
    ]);
});

/*
|--------------------------------------------------------------------------
| PUBLIC ROUTES
|--------------------------------------------------------------------------
*/

Route::get('/courses', function () {

    return [
        [
            'id' => 1,
            'title' => 'Public Speaking',
        ],
        [
            'id' => 2,
            'title' => 'Entrepreneurship',
        ],
    ];

});

/*
|--------------------------------------------------------------------------
| PROGRAMS
|--------------------------------------------------------------------------
*/

Route::get(
    '/programs',
    [ProgramController::class, 'index']
);

Route::get(
    '/programs/{id}/sub-programs',
    [ProgramController::class, 'subPrograms']
);

Route::get(
    '/programs/{id}',
    [ProgramController::class, 'show']
);

Route::get(
    '/sub-programs/{slug}',
    [ProgramController::class, 'showSubProgram']
);

/*
|--------------------------------------------------------------------------
| JADWAL
|--------------------------------------------------------------------------
*/

Route::get(
    '/jadwals',
    [JadwalController::class, 'index']
);

Route::get(
    '/jadwals/calendar',
    [JadwalController::class, 'calendar']
);

/*
|--------------------------------------------------------------------------
| ANNOUNCEMENT
|--------------------------------------------------------------------------
*/

Route::get(
    '/announcements',
    [AnnouncementController::class, 'index']
);

/*
|--------------------------------------------------------------------------
| AUTH
|--------------------------------------------------------------------------
*/

Route::post(
    '/register',
    [AuthController::class, 'register']
);

Route::post(
    '/login',
    [AuthController::class, 'login']
);

/*
|--------------------------------------------------------------------------
| MIDTRANS CALLBACK
|--------------------------------------------------------------------------
*/

Route::post(
    '/midtrans/callback',
    [TransactionController::class, 'callback']
);

/*
|--------------------------------------------------------------------------
| PROTECTED ROUTES
|--------------------------------------------------------------------------
*/

Route::middleware('auth:sanctum')->group(function () {

    /*
    |--------------------------------------------------------------------------
    | AUTH USER
    |--------------------------------------------------------------------------
    */

    Route::post(
        '/logout',
        [AuthController::class, 'logout']
    );

    Route::get(
        '/me',
        [AuthController::class, 'me']
    );

    /*
    |--------------------------------------------------------------------------
    | TRANSACTION
    |--------------------------------------------------------------------------
    */

    Route::post(
        '/create-transaction',
        [TransactionController::class, 'createTransaction']
    );

    Route::post(
        '/callback',
        [TransactionController::class, 'callback']
    );

    /*
    |--------------------------------------------------------------------------
    | MY COURSES
    |--------------------------------------------------------------------------
    */

    Route::get(
        '/my-courses',
        [CourseController::class, 'myCourses']
    );

    Route::get(
        '/my-courses/{slug}',
        [CourseController::class, 'showMyCourse']
    );

    /*
    |--------------------------------------------------------------------------
    | MY SCHEDULE
    |--------------------------------------------------------------------------
    */

    Route::get(
        '/my-schedule',
        [ScheduleController::class, 'mySchedule']
    );

    /*
    |--------------------------------------------------------------------------
    | MY certificates
    |--------------------------------------------------------------------------
    */

    Route::get(
        '/my-certificates',
        [CertificateController::class, 'myCertificates']
    );

    Route::get(
        '/my-certificates/{slug}',
        [CertificateController::class, 'show']
    );

    /*
    |--------------------------------------------------------------------------
    | MY profile
    |--------------------------------------------------------------------------
    */

    Route::get(
        '/profile',
        [ProfileController::class, 'me']
    );

    Route::put(
        '/profile',
        [ProfileController::class, 'update']
    );

    /*
    |--------------------------------------------------------------------------
    | MY notifications
    |--------------------------------------------------------------------------
    */

    Route::get(
        '/notifications',
        [NotificationController::class, 'index']
    );

    Route::post(
        '/notifications/{id}/read',
        [NotificationController::class, 'markAsRead']
    );


});

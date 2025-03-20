<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CourseController;

// Routes d'authentification
Route::post('/register/client', [AuthController::class, 'registerClient']);
Route::post('/register/chauffeur', [AuthController::class, 'registerChauffeur']);
Route::post('/login', [AuthController::class, 'login']);

// Routes protégées par Sanctum
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);

    // Routes pour les clients
    Route::post('/courses', [CourseController::class, 'createCourse']);
    Route::get('/courses/{id}', [CourseController::class, 'showCourse']);

    // Routes pour les chauffeurs
    Route::get('/courses', [CourseController::class, 'listCourses']);
    Route::post('/courses/{id}/accept', [CourseController::class, 'acceptCourse']);
});

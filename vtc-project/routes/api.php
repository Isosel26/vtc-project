<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\AdminController;

// Routes d'authentification
Route::post('/register/client', [AuthController::class, 'registerClient']);
Route::post('/register/chauffeur', [AuthController::class, 'registerChauffeur']);
Route::post('/login', [AuthController::class, 'login']);

// Connexion admin (route publique séparée)
Route::post('/admin/login', [AdminController::class, 'login']);

// Routes protégées par Sanctum
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);

    // Routes pour les clients
    Route::post('/courses', [CourseController::class, 'createCourse']);
    Route::get('/courses/{id}', [CourseController::class, 'showCourse']);
    Route::get('/client/courses', [CourseController::class, 'clientCourses']);

    // Routes pour les chauffeurs
    Route::get('/courses', [CourseController::class, 'listCourses']);
    Route::post('/courses/{id}/accept', [CourseController::class, 'acceptCourse']);

    // Routes pour l'admin
    Route::get('/admin/chauffeurs', [AdminController::class, 'listChauffeurs']);
    Route::post('/admin/chauffeurs/{id}/approuver', [AdminController::class, 'approuver']);
    Route::post('/admin/chauffeurs/{id}/refuser', [AdminController::class, 'refuser']);
});

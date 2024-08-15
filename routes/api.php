<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ProjectController;
use App\Http\Controllers\Api\TaskController;
use App\Http\Controllers\Api\SubtaskController;

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

// // Public routes
Route::post('register', [AuthController::class, 'register'])->name('register');
Route::post('login', [AuthController::class, 'login'])->name('login');

//Protected Routes
Route::middleware('auth:api')->group(function () {
    // Project Routes
    Route::apiResource('projects', ProjectController::class);

    // Task Routes
    Route::apiResource('projects.tasks', TaskController::class);

    // Subtask Routes
    Route::apiResource('tasks.subtasks', SubtaskController::class);

    //Logout
    Route::post('logout', [AuthController::class, 'logout']);

    //Generate Report
    Route::get('projects/{projectId}/report', [ProjectController::class, 'generateReport']);
});

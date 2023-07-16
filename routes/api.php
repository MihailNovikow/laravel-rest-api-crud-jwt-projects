<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Api\ProjectController;
use App\Http\Controllers\Api\TaskController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\SearchController;
use App\Http\Controllers\Api\SendController;

Route::post('login',[AuthController::class, 'login'])->name('login');
    Route::post('register', [AuthController::class, 'register']);
    Route::post('logout', [AuthController::class, 'logout']);
    Route::post('refresh', [AuthController::class, 'refresh']);
Route::get('user/{id}', [UserController::class, 'singleUser']);
Route::get('users', [UserController::class, 'index']);

Route::group(['middleware' => 'auth:api'], function() {
Route::post('user/{id}/projects', [SearchController::class, 'search']);
Route::get('projects', [ProjectController::class, 'index']);
Route::get('/projects/{id}',  [ProjectController::class, 'show']);
Route::post('/projects',  [ProjectController::class, 'store']);
Route::put('/projects/{id}',  [ProjectController::class, 'update']);
Route::delete('/projects/{id}',  [ProjectController::class, 'destroy']);

Route::get('/projects/{id}/simple-tasks-list',  [TaskController::class, 'singleProjectTasks']);
Route::post('/projects/{id}/tasks',  [TaskController::class, 'store']);
Route::put('/projects/{id}/tasks/{task_id}',  [TaskController::class, 'update']);
Route::delete('/projects/{id}/tasks/{task_id}',  [TaskController::class, 'destroy']);

Route::get('send/text', [SendController::class, 'sendText']);
});


<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegistrationController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\TodoListController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource("todo-lists", TodoListController::class);
    Route::apiResource("todo-lists.tasks", TaskController::class)
         ->except(["show"])
         ->shallow();
});

Route::post("/register", RegistrationController::class)->name("auth.register");
Route::post("login", LoginController::class)->name("login");

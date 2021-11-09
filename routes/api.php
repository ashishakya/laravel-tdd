<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegistrationController;
use App\Http\Controllers\Google\ServiceController;
use App\Http\Controllers\LabelController;
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
    Route::apiResource("labels", LabelController::class);
    Route::get("google/web-service/connect/{service}", [ServiceController::class, "connect"])->name("google.service.connect");
    Route::post("google/web-service/callback", [ServiceController::class, "callback"])->name("google.service.callback");
});

Route::post("/register", RegistrationController::class)->name("auth.register");
Route::post("login", LoginController::class)->name("login");

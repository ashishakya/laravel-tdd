<?php

use App\Http\Controllers\TodoListController;
use Illuminate\Http\Request;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::resource("todo-lists", TodoListController::class)->only(["index", "show", "store"]);
//Route::get('todo-lists', [TodoListController::class, 'index'])->name('todo-list.index');
//Route::get('todo-lists/{id}', [TodoListController::class, 'show'])->name('todo-list.show');
//Route::post('todo-lists', [TodoListController::class, 'store'])->name('todo-list.store');

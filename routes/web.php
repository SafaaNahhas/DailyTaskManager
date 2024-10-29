<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Task\TaskController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::middleware('auth')->group(function () {
    
    Route::get('/tasks/trashed', [TaskController::class, 'trashedTasks'])->name('tasks.trashed');
    Route::resource('tasks', TaskController::class);
    Route::post('/tasks/{task}/toggle-status', [TaskController::class, 'toggleStatus'])->name('tasks.toggleStatus');
    Route::post('/tasks/{task}/restore', [TaskController::class, 'restoreTask'])->name('tasks.restore');
    Route::delete('/tasks/{task}/force-delete', [TaskController::class, 'forceDeleteTask'])->name('tasks.forceDelete');

});

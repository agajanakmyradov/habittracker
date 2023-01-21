<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TrackerController;
use App\Http\Controllers\ProcessController;
use App\Http\Controllers\CommentController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/



Auth::routes();

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


Route::prefix('/tracker')->group(function() {
    Route::get('/create', [TrackerController::class, 'create'])->name('tracker.create');

    Route::get('/test', [TrackerController::class, 'test']);

    Route::get('/processess', [TrackerController::class, 'processes'])->name('processes');

    Route::post('/store', [TrackerController::class, 'store'])->name('tracker.store');

    Route::get('/{id}', [TrackerController::class, 'index'])->name('tracker.show');

    Route::get('/delete/{id}', [TrackerController::class, 'delete'])->name('tracker.delete');

});

Route::prefix('/process')->group(function() {
    Route::get('/update/{id}', [ProcessController::class, 'update'])->name('process.update');
});

Route::prefix('/comment')->group(function() {
    Route::post('/store/{tracker_id}', [CommentController::class, 'store'])->name('comment.store');

    Route::get('/delete/{id}', [CommentController::class, 'delete'])->name('comment.delete');

    Route::post('/update/{id}', [CommentController::class, 'update'])->name('comment.update');
});
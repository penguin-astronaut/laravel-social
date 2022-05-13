<?php

use App\Http\Controllers\{CommentController, IndexController, ProfileController};
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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

Route::get('/',[IndexController::class, 'index']);

Route::get('/profiles', [ProfileController::class, 'index'])->name('profiles');
Route::get('/profile/{id}', [ProfileController::class, 'board'])->name('profile')
    ->where('id', '\d+');

Route::middleware('auth')->group(function () {
    Route::post('/comments/create', [CommentController::class, 'create'])->name('comments.create');
    Route::get('/comments/delete/{id}', [CommentController::class, 'delete'])->name('comments.delete')
        ->where('id', '\d+');
});
Route::get('/comments', [CommentController::class, 'index'])->name('comments.index');
Route::post('/comments/load', [CommentController::class, 'load'])->name('comments.load');

Auth::routes(['reset' => false]);

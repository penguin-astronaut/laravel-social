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
Route::get('/profile/{id}', [ProfileController::class, 'board'])
    ->where('id', '\d+');

Route::middleware('auth')->group(function () {
    Route::post('/comment/create', [CommentController::class, 'create']);
    Route::get('/comment/delete/{id}', [CommentController::class, 'delete'])
        ->where('id', '\d+');
});
Route::post('/comment/load', [CommentController::class, 'load']);

Auth::routes(['reset' => false]);

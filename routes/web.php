<?php

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

Route::get('/', [App\Http\Controllers\IndexController::class, 'index']);
Route::get('/profile/{id}', [App\Http\Controllers\ProfileController::class, 'board'])
    ->where('id', '\d+');
Route::post('/comment/create', [\App\Http\Controllers\CommentController::class, 'create']);

Auth::routes(['reset' => false]);

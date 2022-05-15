<?php

use App\Http\Controllers\{
    CommentController,
    IndexController,
    ProfileController,
    BooksController,
};
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


Route::name('books.')
    ->prefix('books')
    ->group(function () {
        Route::middleware('owner')->group(function () {
            Route::get('/{book}/edit', [BooksController::class, 'edit'])->name('edit')
                ->where('id', '\d+');
            Route::put('/{book}', [BooksController::class, 'update'])->name('update')
                ->where('id', '\d+');
            Route::get('/{book}/delete', [BooksController::class, 'destroy'])->name('destroy')
                ->where('id', '\d+');
        });

        Route::middleware('auth')->group(function () {
            Route::get('/', [BooksController::class, 'index'])->name('index');
            Route::get('/create', [BooksController::class, 'create'])->name('create');
            Route::post('/', [BooksController::class, 'store'])->name('store');
        });

        Route::get('/{book}', [BooksController::class, 'show'])->name('show')
            ->where('id', '\d+');
    });


Auth::routes(['reset' => false]);

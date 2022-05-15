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


Route::name('comments.')
    ->prefix('comments')
    ->controller(CommentController::class)
    ->group(function () {
        Route::middleware('auth')->group(function () {
            Route::get('/', 'index')->name('index');
            Route::post('/create', 'create')->name('create');
            Route::get('/delete/{id}', 'delete')->name('delete')
                ->where('id', '\d+');
        });

        Route::post('/load',  'load')->name('load');
    });


Route::name('books.')
    ->prefix('books')
    ->controller(BooksController::class)
    ->group(function () {
        Route::middleware('owner')->group(function () {
            Route::get('/{book}/edit', 'edit')->name('edit')
                ->where('id', '\d+');
            Route::put('/{book}', 'update')->name('update')
                ->where('id', '\d+');
            Route::get('/{book}/delete', 'destroy')->name('destroy')
                ->where('id', '\d+');
            Route::get('/{book}/shared', 'shared')->name('shared')
                ->where('id', '\d+');
            Route::get('/{book}/unshared', 'unshared')->name('unshared')
                ->where('id', '\d+');
        });

        Route::middleware('auth')->group(function () {
            Route::get('/', [BooksController::class, 'index'])->name('index');
            Route::get('/create', [BooksController::class, 'create'])->name('create');
            Route::post('/', [BooksController::class, 'store'])->name('store');
            Route::get('/{user}/shared_all', 'sharedAll')->name('shared_all')
                ->where('id', '\d+');
            Route::get('/{user}/unshared_all', 'unsharedAll')->name('unshared_all')
                ->where('id', '\d+');
        });

        Route::get('/{book}', [BooksController::class, 'show'])->name('show')
            ->where('id', '\d+');
    });


Auth::routes(['reset' => false]);

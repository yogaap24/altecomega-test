<?php

use App\Http\Controllers\Author\AuthorController;
use App\Http\Controllers\Book\BookController;
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

Route::group(['prefix' => 'v1'], function () {
    Route::prefix('auth')->group(function () {
        Route::post('/login', 'Auth\AuthController@login')->name('auth.login');
        Route::post('/register', 'Auth\AuthController@register')->name('auth.register');
    });
    Route::group(['middleware' => 'auth:sanctum'], function () {
        Route::prefix('auth')->group(function () {
            Route::get('/profile', 'Auth\AuthController@profile')->name('auth.profile');
            Route::put('/fcm-token', 'Auth\AuthController@updateFcm')->name('auth.updateFcm');
            Route::post('/logout', 'Auth\AuthController@logout')->name('auth.logout');
        });

        Route::group(['prefix' => 'users'], function () {
            Route::get('', 'UserController@index')->name('users.index');
            Route::post('', 'UserController@store')->name('users.store');
            Route::get('/{id}', 'UserController@show')->name('users.show');
            Route::put('/{id}', 'UserController@update')->name('users.update');
            Route::delete('/{id}', 'UserController@destroy')->name('users.destroy');
        });

        Route::group(['prefix' => 'notifications'], function () {
            Route::get('', 'NotificationController@index')->name('notifications.index');
            Route::post('', 'NotificationController@store')->name('notifications.store');
            Route::get('/{id}', 'NotificationController@show')->name('notifications.show');
            Route::put('/{id}', 'NotificationController@update')->name('notifications.update');
            Route::delete('/{id}', 'NotificationController@destroy')->name('notifications.destroy');
        });
    });

    Route::group(['prefix' => 'authors'], function () {
        Route::get('', [AuthorController::class, 'index'])->name('authors.index');
        Route::post('', [AuthorController::class, 'store'])->name('authors.store');
        Route::get('/{id}', [AuthorController::class, 'show'])->name('authors.show');
        Route::get('/{id}/books', [AuthorController::class, 'books'])->name('authors.books');
        Route::put('/{id}', [AuthorController::class, 'update'])->name('authors.update');
        Route::delete('/{id}', [AuthorController::class, 'destroy'])->name('authors.destroy');
    });

    Route::group(['prefix' => 'books'], function () {
        Route::get('', [BookController::class, 'index'])->name('books.index');
        Route::post('', [BookController::class, 'store'])->name('books.store');
        Route::get('/{id}', [BookController::class, 'show'])->name('books.show');
        Route::put('/{id}', [BookController::class, 'update'])->name('books.update');
        Route::delete('/{id}', [BookController::class, 'destroy'])->name('books.destroy');
    });
});

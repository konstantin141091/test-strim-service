<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Frontend\IndexController as FrontendIndexController;
use App\Http\Controllers\Frontend\StreamController as FrontendStreamController;

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

require __DIR__.'/auth.php';

Route::get('/message', [FrontendIndexController::class, 'message'])->name('message');
Route::group([
    'middleware' => 'auth',
], function () {
    Route::get('/', [FrontendIndexController::class, 'index'])->name('index');
    Route::group([
        'prefix' => 'stream',
        'as' => 'stream.'
    ], function () {
        Route::get('/create', [FrontendStreamController::class, 'create'])->name('create');
        Route::get('/show/{stream}', [FrontendStreamController::class, 'show'])->name('show')->middleware('check_user_stream');
        Route::post('/store', [FrontendStreamController::class, 'store'])->name('store');
    });
    Route::get('stream-password/{stream_id}', [FrontendStreamController::class, 'passwordForm'])->name('stream-password');
    Route::post('stream-password/{stream_id}', [FrontendStreamController::class, 'checkPasswordForm'])->name('check-stream-password');

});




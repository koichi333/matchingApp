<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SwipeController;
use App\Http\Controllers\MatchController;
use App\Http\Controllers\MessageController;

use Illuminate\Support\Facades\Auth;

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

// Route::get('/done', function(){
//     return view('done');
// })->name('done');


Route::group(['middleware' => 'auth'], function () {
    Route::get('/', [UserController::class, 'index'])->name('users.index');
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::post('/users', [UserController::class, 'index'])->name('users.index');

    Route::post('/swipes', [SwipeController::class, 'store'])->name('swipes.store');

    Route::get('/matches', [MatchController::class, 'index'])->name('matches.index');

    Route::get('/message', [MessageController::class, 'index'])->name('message.index');
    Route::post('/message', [MessageController::class, 'sendMessage'])->name('message.sendMessage');
    Route::get('/result/ajax', [MessageController::class, 'getData']);
});

<?php

declare(strict_types=1);

use App\Http\Controllers\TransactionsController;
use App\Http\Controllers\UsersController;
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

Route::group(
    ['prefix' => 'users'],
    function () {
        Route::get('', [UsersController::class, 'allUsers']);
    }
);

Route::group(
    ['prefix' => 'transaction'],
    function () {
        Route::get('', [TransactionsController::class, 'index']);
        Route::post('', [TransactionsController::class, 'receiveTransaction']);
    }
);


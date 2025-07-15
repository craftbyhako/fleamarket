<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\MypageController;
use App\Http\Controllers\ItemController;



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

Route::post('/resister', [UserController::class, 'storeUser']);
Route::post('/mypage', [UserController::class, 'storePlofile']);
Route::get('/', [ItemController::class, 'index']);

// Auth処理
Route::middleware('auth')->group(function () {
    Route::get('/', [MypageController::class, 'admin']);
    
    Route::get('/mypage', [MypageController::class, 'profile']);

    Route::post('/mypage/upload', [UserController::class, 'upload']);

    Route::get('/', [ItemController::class, 'index']);

    // Route::post('/logout', [AuthenticatedSessionController::class, 'destroy' ]);
});
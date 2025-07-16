<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\UserController;
use App\Http\Controllers\MylistController;
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
Route::get('/register', function() {
    return view('auth.register');
});

Route::post('/register', [UserController::class, 'storeUser']);

Route::post('/mypage', [UserController::class, 'storePlofile']);

// 非会員のトップページ表示
Route::get('/', [ItemController::class, 'index']);

// 会員登録
Route::post('/resister', [UserController::class, 'storeUser']);

// Auth処理
Route::middleware('auth')->group(function () {

    // 初回プロフィール登録ページの表示
    Route::get('/mypage', [UserController::class, 'profile']);

    // 初回プロフィール情報・写真の保存
    Route::post('/mypage', [UserController::class, 'upload']);

    // 会員のトップページの表示（adminで表示)
    Route::get('/', [MylistController::class, 'admin']);

    
    
    // Route::post('/logout', [AuthenticatedSessionController::class, 'destroy' ]);
});
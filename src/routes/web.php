<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\UserController;
use App\Http\Controllers\MylistController;
use App\Http\Controllers\ItemController;
use Illuminate\Http\Request;
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

// 全ユーザーに共通の / ルート
Route::get('/', function (Request $request) {
    if (Auth::check() && $request->query('tab') === 'mylist') {
        return app()->call([MylistController::class, 'admin']);
    }
    return app()->call([ItemController::class, 'index']);
});

Route::middleware('guest')->group (function () {

    Route::get('/register', function() {
    return view('auth.register');
    });

    // 会員登録
    Route::post('/register', [UserController::class, 'storeUser']);

    // プロフィール登録
    Route::post('/mypage', [UserController::class, 'storePlofile']);
});




// // soldout表示
// Route::get('/', [ItemController::class, 'show']);


// Auth処理
Route::middleware('auth')->group(function () {

    

    // 初回プロフィール登録ページの表示
    Route::get('/mypage', [UserController::class, 'profile']);

    // 初回プロフィール情報・写真の保存
    Route::post('/mypage', [UserController::class, 'upload']);

    

    
    
    // Route::post('/logout', [AuthenticatedSessionController::class, 'destroy' ]);
});
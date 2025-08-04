<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\UserController;
use App\Http\Controllers\MylistController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\LikeController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Comment;




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

// 会員・非会員共通のトップ画面
Route::get('/', [ItemController::class, 'index'])->name('home');

Route::get('/item/{item_id}', [ItemController::class, 'show']);

Route::middleware('guest')->group (function () {
    
    Route::get('/register', function() {
    return view('auth.register');
    });

    // 会員登録
    Route::post('/register', [UserController::class, 'storeUser']);

     // ログインページ表示
    Route::get('/login', function () {
        return view('auth.login');
    })->name('login');

    // ログイン処理
    Route::post('/login', [UserController::class, 'loginUser'])->name('login');


});



// Auth処理
Route::middleware('auth')->group(function () {
    
    // プロフィール登録
    Route::post('/mypage', [UserController::class, 'storePlofile']);


    Route::get('/', [MylistController::class, 'admin'])->name('mylist');

    

    // 初回プロフィール登録ページの表示
    Route::get('/mypage', [UserController::class, 'profile']);

    // 初回プロフィール情報・写真の保存
    Route::post('/mypage', [UserController::class, 'upload']);

    // コメント投稿 
    Route::post('/comments', function(Request $request)
    {
        $request->validate([
            'item_id' => 'required|exists:items,id',
            'content' => 'required|string|max:1000',
        ]);

        Comment::create([
            'item_id' => $request->item_id,
            'user_id' => Auth::id(),
            'content' => $request->content,
        ]);

        return redirect()->back()->with('success', 'コメントを投稿しました。');

    })->name('comments.store');   

    // いいね機能
    Route::post('/items/{id}/like', [LikeController::class, 'toggleLike']);

    
    
    // Route::post('/logout', [AuthenticatedSessionController::class, 'destroy' ]);
});


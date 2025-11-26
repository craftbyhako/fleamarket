<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\UserController;
use App\Http\Controllers\MylistController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\ChatController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Comment;
use App\Http\Requests\CommentRequest;





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

Route::get('/item/{item_id}', [ItemController::class, 'show'])->name('item.show');


// ゲスト
Route::middleware('guest')->group (function () {

    // 登録ページ表示（Fortify）
    Route::get('/register', [\Laravel\Fortify\Http\Controllers\RegisteredUserController::class, 'create']);
    
    // 会員登録の実行（Fortify）
    Route::post('/register', [\Laravel\Fortify\Http\Controllers\RegisteredUserController::class, 'store']);

     // ログインページ表示
    Route::get('/login', function ()
    {
        return view('auth.login');
    })->name('login');

    // ログインの実行
    Route::post('/login', [UserController::class, 'loginUser'])->name('login');
    
});



// 認証済ユーザー用、Auth処理
Route::middleware('auth')->group(function () {
    
    // 初回プロフィール登録ページの表示
    Route::get('/mypage/profile/create', [UserController::class, 'createProfile'])->name('user.createProfile');

    // 初回プロフィール登録
    Route::post('/mypage/profile', [UserController::class, 'storeProfile'])->name('user.storeProfile');

    // ログイン後のトップ画面（マイリストタブ）
    Route::get('/mylist', [MylistController::class, 'admin'])->name('mylist');

     // マイページ画面（出品・購入商品閲覧・プロフ編集画面）
    Route::get('/mypage', [UserController::class, 'adminMypage'])->name('user.adminMypage');

    // ログイン後のプロフィール設定（編集）画面
    Route::get('/mypage/profile/edit', [UserController::class, 'editProfile'])->name('user.editProfile');

    // プロフィール更新の実行
    Route::patch('/mypage/profile', [UserController::class, 'updateProfile'])->name('user.updateProfile');



    // コメント投稿 
    Route::post('/comments', function(CommentRequest $request)
    {
        Comment::create([
            'item_id' => $request->item_id,
            'user_id' => Auth::id(),
            'content' => $request->content,
        ]);

        return redirect()->back()->with('success', 'コメントを投稿しました。');

    })->name('comments.store');   

    // いいね機能
    Route::post('/items/{id}/like', [LikeController::class, 'toggleLike']);

    // 商品購入画面の表示
    Route::get('/purchase/{item}', [PurchaseController::class, 'showForm'])->name('purchase.form');

    // 購入配送先変更画面の表示
    Route::get('/purchase/address/{item_id}', [PurchaseController::class, 'showDestination'])->name('purchase.showDestination');

    // 購入配送先変更の実行
    Route::patch('/purchase/address/{item_id}', [PurchaseController::class, 'updateDestination'])->name('purchase.updateDestination');

    // 購入の登録
    Route::post('/purchase/{item_id}', [PurchaseController::class, 'store'])->name('purchase.store');

    // ログイン後のプロフィール設定（編集）画面
    Route::get('/mypage/profile', [UserController::class, 'editProfile'])->name('user.editProfile');

    // プロフィール更新の実行
    Route::patch('/mypage/profile', [UserController::class, 'updateProfile'])->name('user.updateProfile');

    Route::post('/logout', function () {
    Auth::logout();
    return redirect('/');
    })->name('logout');

    Route::get('/sell', [ItemController::class, 'create'])->name('item.create');

    Route::post('/sell', [ItemController::class, 'store'])->name('item.store');

    Route::get('/chat/{sold_id}', [ChatController::class, 'show'])->name('chat.show');

    Route::post('/chat/{sold_id}', [ChatController::class, 'store'])->name('chat.store');

    
});


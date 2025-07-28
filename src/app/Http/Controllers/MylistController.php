<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Like;
use App\Models\Item;




class MylistController extends Controller
{
   
    
    // ログイン後の一覧画面
    public function admin(Request $request){

        $user = Auth::user();
        $userId = Auth::id();
        $tab = $request->query('tab', ''); 
        
        // おすすめ
        $query = Item::with('user', 'sold');
        if ($user) {
            $query->where('user_id', '<>', $user->id);
        }
            $items = $query->get();




        // マイリスト
        if ($tab === 'mylist') {
            if ($user) {
                $likedItemIds = $user->likes()->pluck('item_id');
                $items = Item::whereIn('id', $likedItemIds)->with('user', 'likes')->get();
            } else {
            // 未ログイン時のマイリスト → 空のコレクション
            $items = collect(); // 空データを返す
            }
        }
        
        return view ('mylist.index', compact('items', 'tab'));
    }
    }

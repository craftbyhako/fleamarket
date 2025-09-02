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
        $tab = $request->query('tab', 'mylist'); 
        $keyword = $request->input('keyword', null);

        if ($tab === 'mylist') {

             // いいねした商品を取得 ──────────────
            $likedItems = $user->likedItems()->with('user', 'sold');
            if (!empty($keyword)) {
            $likedItems->where('item_name', 'like', '%' . $keyword . '%');
            }
            $likedItems = $likedItems->get();

            // 購入済み商品を取得 ──────────────
            $purchasedItems = Item::with('user', 'sold')
             ->whereHas('sold', function($query) use ($user) {
            $query->where('user_id', $user->id);
            });
            if (!empty($keyword)) {
            $purchasedItems->where('item_name', 'like', '%' . $keyword . '%');
            }
            $purchasedItems = $purchasedItems->get();

        //  マージして重複を削除 ──────────────
            $items = $likedItems->merge($purchasedItems)->unique('id');

            foreach($items as $item) {
                $item->isSold = $item->sold !==null;
            }

            } elseif ($tab === 'recommend') {
                $query = Item::with('user', 'sold');
                if ($user) {
                    $query->where('user_id', '<>', $user->id);
                }
                if (!empty($keyword)) {
                    $query->where('item_name', 'like', '%' . $keyword . '%');
                }        
                $items = $query->get();
                foreach ($items as $item) {
                    $item->isSold = $item->sold !== null;
        }
        } else {
            $items = collect();
        }        

        $sellItems = $tab === 'mylist' ? $items : collect();

    return view ('mylist.index', [
        'items' => $items,
        'sellItems' => $sellItems,
        'tab' => $tab,
        'keyword' =>$keyword,
    ]); 
    }


    public function show($item_id)
    {
        $item = Item::with('user', 'categories', 'comments.user', 'condition')->withCount(['likes', 'comments'])->findOrFail($item_id);
        $comments = $item->comments;


        return view('item', compact('item', 'comments'));
    }
}

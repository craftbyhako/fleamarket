<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Item;

class MylistController extends Controller
{
    public function admin(Request $request)
    {
        $user = Auth::user();
        $tab = $request->query('tab', 'mylist'); // デフォルトはマイリスト
        $keyword = $request->input('keyword', null);

        if ($tab === 'recommend') {
            // おすすめタブ：自分の出品を除外 & いいねしていない商品
            $likedIds = $user ? $user->likedItems()->pluck('items.id')->toArray() : [];

            $items = Item::with(['user', 'sold'])
                ->when($user, fn($q) => $q->where('items.user_id', '<>', $user->id))
                ->when(!empty($likedIds), fn($q) => $q->whereNotIn('id', $likedIds))
                ->when($keyword, fn($q) => $q->where('item_name', 'like', "%{$keyword}%"))
                ->get();
        } else {
            // マイリストタブ：いいねした商品 & 自分の出品は除外
            $items = $user->likedItems()
                ->with(['user', 'sold'])
                ->where('items.user_id', '<>', $user->id)
                ->when($keyword, fn($q) => $q->where('item_name', 'like', "%{$keyword}%"))
                ->get();
        }

        return view('mylist.index', [
            'items' => $items,
            'user' => $user,
            'tab' => $tab,
            'keyword' => $keyword,
        ]);
    }

    public function show($item_id)
    {
        $item = Item::with('user', 'categories', 'comments.user', 'condition')
            ->withCount(['likes', 'comments'])
            ->findOrFail($item_id);
        $comments = $item->comments;

        return view('item', compact('item', 'comments'));
    }
}

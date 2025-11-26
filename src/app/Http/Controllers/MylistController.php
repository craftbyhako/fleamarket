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
        $tab = $request->query('tab', 'sell'); // デフォルトは sell
        $keyword = $request->input('keyword', null);

        // 出品した商品
        $sellItems = Item::with('user', 'sold')
            ->whereHas('likes', fn($q) => $q->where('user_id', $user->id))
            ->when($keyword, fn($q) => $q->where('item_name', 'like', ""%$keyword%""))
            ->get();

        // 購入した商品（status = 3 = complete）
        $boughtItems = Item::with('user', 'sold')
            ->whereHas('sold', fn($q) => $q->where('user_id', $user->id)->where('status', 3))
            ->when($keyword, fn($q) => $q->where('item_name', 'like', ""%$keyword%""))
            ->get();

        // 取引中の商品（status = 1,2）
        $pendingItems = Item::with('user', 'sold')
            ->whereHas('sold', fn($q) => $q->where('user_id', $user->id)->whereIn('status', [1, 2]))
            ->when($keyword, fn($q) => $q->where('item_name', 'like', ""%$keyword%""))
            ->get();

        // おすすめタブ用（ログインユーザーがいいねしていない商品）
        if ($tab === 'recommend') {
            $likedIds = $user ? $user->likedItems()->pluck('items.id')->toArray() : [];
            $items = Item::with('user', 'sold')
                ->when($user, fn($q) => $q->where('user_id', '<>', $user->id))
                ->when(!empty($likedIds), fn($q) => $q->whereNotIn('id', $likedIds))
                ->when($keyword, fn($q) => $q->where('item_name', 'like', ""%$keyword%""))
                ->get();
        } else {
            // sell / purchased / pending 用
            switch ($tab) {
                case 'sell':
                    $items = $sellItems;
                    break;
                case 'bought':
                    $items = $boughtItems;
                    break;
                case 'pending':
                    $items = $pendingItems;
                    break;
                default:
                    $items = collect(); // 空コレクション
            }
        }

        return view('mylist.index', [
            'tab' => $tab,
            'keyword' => $keyword,
            'items' => $items,             // Bladeでのループ用
            'sellItems' => $sellItems,
            'boughtItems' => $boughtItems,
            'pendingItems' => $pendingItems,
            'user' => $user,
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

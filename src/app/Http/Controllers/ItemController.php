<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\Sold;

class ItemController extends Controller
{
    public function index(Request $request){

        if (auth()->check()) {
            return redirect()->route('mylist', ['tab' => 'mylist']);
        }

        $keyword = $request->input('keyword');

        // Itemのデータを、user, sold, likes のデータも同時取得する
        $query = Item::with(['user', 'sold', 'likes']);

        if(!empty($keyword)) {
            $query->where('item_name', 'like', '%' . $keyword . '%');
        }

        $items = $query->get();
        return view('home', compact('items', 'keyword'));
    }

    // 詳細画面表示
    public function show($item_id){
    {
        $item = Item::with('user', 'categories', 'comments.user', 'condition')->withCount(['likes', 'comments'])->findOrFail($item_id);
        $comments = $item->comments;


        return view('item', compact('item', 'comments'));
    }
    }


}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\Sold;

class ItemController extends Controller
{
    public function index(){

        // itemsとsold-item,like,userを同時調査して表示
        $items = Item::with(['user', 'sold', 'likes'])->get();
        return view('home', compact('items'));
    }

    // 詳細画面表示
    public function show($item_id){
    {
        $item = Item::with('user', 'category', 'comments.user', 'condition')->find($item_id);
        $comments = $item->comments;

        return view('item', compact('item', 'comments'));
    }
    }
}

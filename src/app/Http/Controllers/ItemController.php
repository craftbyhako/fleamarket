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

    
}


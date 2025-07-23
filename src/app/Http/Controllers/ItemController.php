<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\Sold;

class ItemController extends Controller
{
    public function index(){

        // itemsとsold-itemを同時調査して表示
        $items = Item::with('sold')->get();
        return view('home', compact('items'));
    }

    
}


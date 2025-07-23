<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\Sold;

class ItemController extends Controller
{
    public function index(){

        $items = Item::all();
        return view('mylist.index', compact('items'));
    }

    // soldoutの表示
    public function show($id){
        $item = Item::with('sold')->findOrFail($id);
        return view('mylist.index', compact('item'));
    }
}


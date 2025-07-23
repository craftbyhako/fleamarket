<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\Sold;

class ItemController extends Controller
{
    public function index(){

        $items = Item::all();
        return view('home', compact('items'));
    }

    // soldoutの表示
    public function sold($id){
        $items = Item::with('sold')->get();
        return view('home', compact('items'));
    }
}


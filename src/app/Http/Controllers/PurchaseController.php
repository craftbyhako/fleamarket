<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use Illuminate\Support\Facades\Auth;

class PurchaseController extends Controller
{
    //
    public function showForm(Item $item)
    {
        $user = Auth::user();

        return view ('purchase.purchase', compact('item', 'user')); 
    }
}

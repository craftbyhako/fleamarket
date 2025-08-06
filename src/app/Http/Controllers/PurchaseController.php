<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class PurchaseController extends Controller
{
    //
    public function showForm(Item $item, Request $request)
    {
        $user = Auth::user();

        return view ('purchase.purchase', [
            'item' => $item,
            'user' => $user,
        ]);
    }

    public function showDestination($item_id)
    {
        $item = Item::findOrFail($item_id);
        $user = Auth::user();
        return view('purchase.edit_address', compact('item', 'user'));
    }
}

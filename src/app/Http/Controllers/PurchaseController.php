<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\User;
use App\Models\Sold;
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

    public function store($item_id)
    {
        $item = Item::findOrFail($item_id);
        
        // sold済か確認する
        $isAlreadySold = Sold::where('item_id', $item_id)->exists();

        if($isAlreadySold) {
            return redirect()->back()->with('error', 'この商品は売切れです');
        }

        // 購入履歴を保存する
        Sold::create([
        'item_id' => $item_id,
        'user_id' => Auth::id(),
        ]);

    return redirect()->route('mylist.index')->with('success', '購入が完了しました');

    }



    public function showDestination($item_id)
    {
        $item = Item::findOrFail($item_id);
        $user = Auth::user();
        return view('purchase.edit_address', compact('item', 'user'));
    }


    public function update()
    {
        soldモデルの
    }
}

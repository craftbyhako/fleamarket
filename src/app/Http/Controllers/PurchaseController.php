<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\User;
use App\Models\Sold;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\EditAddressRequest;
use Illuminate\Support\Facades\Session;



class PurchaseController extends Controller
{
    //
    public function showForm(Item $item, Request $request)
    {
        $user = Auth::user();

       if ($request->has('payment')) {
        session(['payment_method' => $request->input('payment')]);
        }

        $payment = session('payment_method', '');

        $address = session('purchase_address', [
        'postcode' => $user->postcode ?? '',
        'address' => $user->address ?? '',
        'building' => $user->building ?? '',
    ]);

        return view('purchase.purchase', [
        'item' => $item,
        'user' => $user,
        'payment' => $payment,
        'address' => $address,
        ]);
    }

    public function store(Request $request,$item_id)
    {


        $user = Auth::user();
        $item = Item::findOrFail($item_id);

        $payment = $request->input('payment');

        if (!$payment) {
            return redirect()->back()->with('error', '支払方法を選択してください');
        }

        $address = session('purchase_address', [
            'postcode' => $user->postcode,
            'address' => $user->address,
            'building' => $user->building,
        ]);

        // sold済か確認する
        $isAlreadySold = Sold::where('item_id', $item_id)->exists();
    
        if($isAlreadySold) {
            return redirect()->back()->with('error', 'この商品は売切れです');
        }

        // 購入履歴を保存する
        Sold::create([
            'item_id' => $item_id,
            'user_id' => Auth::id(),
            'payment' => $payment,
            'destination_postcode' => $address['postcode'],
            'destination_address' => $address['address'],
            'destination_building' => $address['building'] ?? null,
        ]);
        
         $request->session()->forget('purchase_address');

    return redirect()->route('mylist', ['tab' => 'mylist'])->with('success', '購入が完了しました');

    }


    public function showDestination($item_id)
    {
        $item = Item::findOrFail($item_id);
        $user = Auth::user();
        return view('purchase.edit_address', compact('item', 'user'));
    }

    public function updateDestination(EditAddressRequest $request, $item_id)
    {
        session([
            'purchase_address' => [
                'postcode' => $request->input('destination_postcode'),
                'address' => $request->input('destination_address'),
                'building' => $request->input('destination_building'),
            ]
        ]);
            // 確認用
            // dd(session('purchase_address'));
        

        return redirect()->route('purchase.form', ['item' => $item_id])->with('success', '配送先を変更しました。');
    }

    
}

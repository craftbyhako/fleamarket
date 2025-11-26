<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\User;
use App\Models\Sold;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\EditAddressRequest;
use Illuminate\Support\Facades\Session;
use App\Http\Requests\PurchaseRequest;




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

        $tab = $request->query('tab', 'mylist'); 

        return view('purchase.purchase', [
        'item' => $item,
        'user' => $user,
        'payment' => $payment,
        'address' => $address,
        'tab' => $tab,
        ]);
    }

    public function store(PurchaseRequest $request, $item_id)
    {
        $user = Auth::user();
        $item = Item::findOrFail($item_id);

        $validated = $request->validated();

        $payment = $validated['payment'];
        $postcode = $validated['destination_postcode'];
        $address = $validated['destination_address'];
        $building = $validated['destination_building'] ?? null;

        // sold済か確認する
        $isAlreadySold = Sold::where('item_id', $item_id)->exists();
    
        if($isAlreadySold) {
            return redirect()->back()->with('error', 'この商品は売切れです');
        }

        // 購入履歴を保存する
        Sold::create([
            'item_id' => $item_id,
            'user_id' => Auth::id(),
            'status' => 1,
            'payment' => $payment,
            'destination_postcode' => $postcode,
            'destination_address' => $address,
            'destination_building' => $building,
        ]);
        
         $request->session()->forget('purchase_address');

    return redirect()->route('mylist', ['tab' => 'pending']);

    }


    public function showDestination(Request $request, $item_id)
    {
        $item = Item::findOrFail($item_id);
        $user = Auth::user();
        $tab = $request->query('tab', 'mylist');


        return view('purchase.edit_address', compact('item', 'user', 'tab'));
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

        return redirect()->route('purchase.form', ['item' => $item_id])->with('success', '配送先を変更しました。');
    }

    
}

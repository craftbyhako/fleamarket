<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Message;
use App\Models\Sold;


class ChatController extends Controller
{
    public function show($sold_id)
    {
        $sold = Sold::with(['user', 'item'])->findOrFail($sold_id);

        $messages = Message::where('sold_id', $sold_id)
            ->orderBy('created_at')
            ->get();

        return view('mylist.chat', compact('sold', 'messages'));
    }

    public function store(Request $request, $sold_id)
    {
        $request->validate([
            'message' => 'required|string|max:450'
        ]);

        Message::create([
            'sold_id' => $sold_id,
            'user_id' => auth()->id(),
            'message' => $request->message,
        ]);

        $sold = Sold::findOrFail($sold_id);
        $sold->status = 2;
        $sold->save();

        return back();
    }


}

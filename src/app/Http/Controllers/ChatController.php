<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Message;
use App\Models\Sold;
use App\Models\Item;


class ChatController extends Controller
{
    public function show($sold_id)
    {
        // ログインユーザー
        $authUser = auth()->user();

        $trade = Sold::with(['user', 'item.user'])->findOrFail($sold_id);

        // 相手を判定（ログインユーザー＝Soldのユーザー（購入者））
        // 正：相手はItemのユーザー＝出品者
        // 偽：相手はSoldのユーザー＝購入者
        $otherUser = $authUser->id == $trade->user_id ? $trade->item->user : $trade->user;
        
        $pendingTrades = Sold::whereIn('status', [1, 2])
            ->where(function($query) use ($authUser) {
                $query->where('user_id', $authUser->id)
                ->orWhereHas('item', function($q) use ($authUser) {
                    $q->where('user_id', $authUser->id);
                });
            })
        ->get();

        $messages = Message::with('user')
            ->where('sold_id', $sold_id)
            ->orderBy('created_at')
            ->get()
            ->map(function($message) use ($authUser, $otherUser) {
            $isMe = $message->user_id == $authUser->id;

            // Bladeで使うためのプロパティを追加
            $message->is_me = $isMe;
            $message->display_name = $isMe ? $authUser->user_name : $otherUser->user_name;
            $message->display_image = $isMe ? $authUser->profile_image : $otherUser->profile_image;

            return $message;
        });

        $tab = null;

        return view('mylist.chat', compact('trade', 'messages','pendingTrades', 'otherUser'));
    }


    public function store(Request $request, $sold_id)
    {
        $request->validate([
            'new_message' => 'required|string|max:450'
        ]);

        Message::create([
            'sold_id' => $sold_id,
            'user_id' => auth()->id(),
            'message' => $request->new_message,
        ]);

        $sold = Sold::findOrFail($sold_id);
        $sold->status = 2;
        $sold->save();

        return back();
    }


}

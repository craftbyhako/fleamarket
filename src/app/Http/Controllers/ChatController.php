<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Message;
use App\Models\Sold;
use App\Models\Item;
use App\Http\Requests\ChatRequest;



class ChatController extends Controller
{
    public function show($sold_id, Request $request)
    {
        // ログインユーザー
        $authUser = auth()->user();

        $trade = Sold::with(['user', 'item.user'])->findOrFail($sold_id);

        // 相手を判定（ログインユーザー＝Soldのユーザー（購入者））
        // 正：相手はItemのユーザー＝出品者
        // 偽：相手はSoldのユーザー＝購入者
        $otherUser = $authUser->id == $trade->user_id ? $trade->item->user : $trade->user;

        Message::where('sold_id', $sold_id)
            ->where('user_id', '<>', $authUser->id)
            ->where('is_read', false)
            ->update(['is_read' => true]);
        
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

        $editingId = $request->query('edit');

        return view('mylist.chat', compact('trade', 'messages','pendingTrades', 'otherUser', 'editingId', 'sold_id'));
    }


    public function store(ChatRequest $request, $sold_id)
    {
        session(['draft_message_' . $sold_id => $request->message]);

        $data = [
            'sold_id' => $sold_id,
            'user_id' => auth()->id(),
            'message' => $request->message,
        ];

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('message', 'public');
            $data['image'] = $path;
        }

        Message::create($data);

        $sold = Sold::findOrFail($sold_id);
        $sold->status = 2;
        $sold->save();

        session()->forget('draft_message_' . $sold_id);

        return back();
    }

    public function update(Request $request, $message_id)
    {
        $request->validate([
            'content' => 'required|string|max:400'
        ]);

        $message = Message::findOrFail($message_id);
        $message->message = $request->content;
        $message->save();

        return redirect()->route('chat.show', $message->sold_id);
    }


    public function destroy($message_id)
    {
        $message = Message::findOrFail($message_id);
        $message->delete();
        return back();
    }

    public function complete (Request $request, $sold_id)
    { 
        $authUser = auth()->user();
        $sold = SOld::with('item', 'item.user')->findOrFail($sold_id);

        $sold->status = 3;
        $sold->save();

        if ($request->has('rating')) {
            $targetUserId = $authUser->id == $sold->user_id 
                ? $sold->item->user_id
                // 購入者なら出品者評価
                : $sold->user_id;
                // 出品者なら購入者評価
                
            $existingRating = Rating::where('rater_id', $authUser->id)
                ->where('target_user_id', $targetUserId)
                ->first();

            if ($existingRating) {
                $existingRating->score = $request->rating;
                $existingRating->save();
            }else{
                Rating::create([
                    'rating_id' => $authUser->id,
                    'target_user_id' => $targetUserId,
                    'score' => $request->rating,
                ]);
            }            
        }

        return redirect()->route('mylist');
    }


}

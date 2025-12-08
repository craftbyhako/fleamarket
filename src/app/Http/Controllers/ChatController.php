<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Message;
use App\Models\Sold;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Mail;
use App\Mail\TransactionCompleted;
use App\Http\Requests\ChatRequest;


class ChatController extends Controller
{
    public function show($sold_id, ChatRequest $request)
    {
        $authUser = auth()->user();
        $authUserId = $authUser->id;
        $trade = Sold::with(['user', 'item.user'])->findOrFail($sold_id);
        $otherUser = $authUser->id == $trade->user_id ? $trade->item->user : $trade->user;


        // --- 下書き保存（POSTで draft_message が来た場合） ---
        if ($request->isMethod('post') && $request->filled('draft_message')) {
            $targetSoldId = $request->input('input_sold_id_for_draft', $sold_id);
            session(['draft_message_' . $targetSoldId . '_' . $authUserId => $request->input('draft_message')]);

            // リダイレクトで GET に戻す（ブラウザのリロードで消えないように）
            return redirect()->route('chat.show', ['sold_id' => $sold_id]);
        }

        // --- 未読メッセージを既読に ---
        Message::where('sold_id', $sold_id)
            ->where('user_id', '<>', $authUser->id)
            ->where('is_read', false)
            ->update(['is_read' => true]);

        // --- 下書き復元 ---
        
        $draftMessage = session()->get('draft_message_' . $sold_id . '_' . $authUserId) ?? '';

        // --- 取引一覧（サイドバー用） ---
        $pendingTrades = Sold::whereIn('status', [1, 2, 3])
            ->where(function ($q) use ($authUser) {
                $q->where('user_id', $authUser->id)
                    ->orWhereHas('item', fn($q2) => $q2->where('user_id', $authUser->id));
            })->get();

        // --- メッセージ取得 ---
        $messages = Message::with('user')
            ->where('sold_id', $sold_id)
            ->orderBy('created_at')
            ->get()
            ->map(function ($message) use ($authUser, $otherUser) {
                $message->is_me = $message->user_id == $authUser->id;
                $message->display_name = $message->is_me ? $authUser->user_name : $otherUser->user_name;
                $message->display_image = $message->is_me ? $authUser->profile_image : $otherUser->profile_image;
                return $message;
            });

        $editingId = $request->query('edit');

        $buyerRated = \App\Models\Rating::where('rater_id', $trade->user_id)
            ->where('target_user_id', $trade->item->user_id)
            ->where('sold_id', $trade->id)
            ->exists();

        $sellerRated = \App\Models\Rating::where('rater_id', $trade->item->user_id)
            ->where('target_user_id', $trade->user_id)
            ->where('sold_id', $trade->id)
            ->exists();

        $shouldShowRatingModal = false;

        $isBuyer = $authUser->id == $trade->user_id;
        $isSeller = $authUser->id == $trade->item->user_id;

        // ステータス：取引完了段階以上でのみ評価モーダル表示
        if ($trade->status >= 3) {

            // 購入者が評価していなければ表示
            if ($isBuyer && !$buyerRated) {
                $shouldShowRatingModal = true;
            }

            // 出品者が評価していなければ表示
            if ($isSeller && !$sellerRated) {
                $shouldShowRatingModal = true;
            }
        }

        $openModal = $request->query('open');
        if ($openModal === 'buyer') {
            $shouldShowRatingModal = true;
        }

        return view('mylist.chat', compact(
            'trade',
            'messages',
            'pendingTrades',
            'otherUser',
            'editingId',
            'sold_id',
            'shouldShowRatingModal',
            'draftMessage',
            
        ));
    }

    // メッセージ送信
    public function store(ChatRequest $request, $sold_id)
    {
        $authUser = auth()->user();
        $trade = Sold::findOrFail($sold_id);

        // 下書き保存
        $authUserId = $authUser->id;
        $draftMessage = $request->input('draft_message', '');
        session(['draft_message_' . $sold_id . '_' . $authUserId => $draftMessage]);

        // 送信ボタン押下時のみメッセージ作成
        if ($request->filled('send_message') && $draftMessage !== '') {

            $data = [
                'sold_id' => $sold_id,
                'user_id' => $authUser->id,
                'message' => $draftMessage,
            ];

            if ($request->hasFile('image')) {
                $data['image'] = $request->file('image')->store('message', 'public');
            }

            Message::create($data);

            // 送信後は下書きクリア
            session()->forget('draft_message_' . $sold_id  . '_' . $authUserId);

            // 取引ステータス更新
            if ($trade->status < 2) {
                $trade->status = 2;
                $trade->save();
            }
        }

        return redirect()->route('chat.show', ['sold_id' => $sold_id]);
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

    // 取引完了（モーダル送信）
    public function complete(Request $request, $sold_id)
    {
        $authUser = Auth::user();
        $sold = Sold::with(['user', 'item.user'])->findOrFail($sold_id);
        $isBuyer = $authUser->id == $sold->user_id;

        if (!$request->has('rating') && $isBuyer) {

            $sold->status = 3;
            $sold->save();

            return redirect()->route('chat.show', $sold_id);
        }

        if ($request->has('rating')) {

            $targetUserId = $isBuyer ? $sold->item->user_id : $sold->user_id;

            \App\Models\Rating::updateOrCreate(
                [
                    'rater_id' => $authUser->id,
                    'target_user_id' => $targetUserId,
                    'sold_id' => $sold->id,
                ],
                ['score' => $request->rating]
            );

            $buyerRated = \App\Models\Rating::where('rater_id', $sold->user_id)
                ->where('target_user_id', $sold->item->user_id)
                ->where('sold_id', $sold->id)
                ->exists();

            $sellerRated = \App\Models\Rating::where('rater_id', $sold->item->user_id)
                ->where('target_user_id', $sold->user_id)
                ->where('sold_id', $sold->id)
                ->exists();

              
            
            // ステータス更新
            if ($isBuyer) {
                $sold->status = 3; // 購入者が評価したらまず status=3
               
                Mail::to($sold->item->user->email)
                    ->send(new TransactionCompleted($sold->item, $sold->user));

            } else {

                $sold->status = $buyerRated ? 4 : 2;
            }
            $sold->save();
        }

        return redirect()->route('chat.show', $sold_id);
    }
    
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Like;
use App\Models\Item;




class MylistController extends Controller
{
   
    
    // ログイン後の一覧画面
    public function admin(Request $request){

        $user = Auth::user();
        // $userId = Auth::id();
        $tab = $request->query('tab', 'mylist'); 

        $keyword = $request->input('keyword', null);

        if (!empty($keyword)) {
            $tab = 'recommend' ;
        }

        if ($tab === 'mylist') {
            $items = $user->likedItems()->with('user', 'sold')->get();

            foreach ($items as $item) {
                $item->isSold = $item->sold !==null;
            }
        } elseif ($tab === 'recommend') {
            $query = Item::with('user', 'sold');
            
            if ($user) {
                $query->where('user_id', '<>', $user->id);
            }

            if(!empty($keyword)) {
                $query->where('item_name', 'like', '%' . $keyword . '%');
            }        
        
            $items = $query->get();
            foreach($items as $item) {
                $item->isSold = $item->sold !==null;
            }
        } else {
            $items = collect();
        }        

    return view ('mylist.index',compact('items', 'tab', 'keyword')); 
    }


    public function show($item_id)
    {
        $item = Item::with('user', 'categories', 'comments.user', 'condition')->withCount(['likes', 'comments'])->findOrFail($item_id);
        $comments = $item->comments;


        return view('item', compact('item', 'comments'));
    }
}

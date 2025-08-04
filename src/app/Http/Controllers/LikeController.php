<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\Like;
use Illuminate\Support\Facades\Auth;



class LikeController extends Controller
{
 public function toggleLike($id){
 
    $user = Auth::user();
    $item = Item::findOrFail($id);

    $liked = $user->likedItems()->where('item_id', $item->id)->exists();

    if ($liked) {
        $user->likedItems()->detach($item->id);
    }else{
        $user->likedItems()->attach($item->id);
    }
    return redirect()->back();
    }
 }

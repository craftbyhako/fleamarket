<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Like;



class MypageController extends Controller
{
    public function profile(){
        return view('auth.profile');
    }
    
    // ログイン後の一覧画面
    public function mypage(Request $request){

        $userId = Auth::id();
        $likes = Like::where('user_id', $userId)->get();
        $tab = $request->query('tab');
       
        return view ('mypage.index', compact('likes', 'tab'));
    }


    // そして、コントローラーでこう処理します：

    // public function admin(Request $request)
    // {
    //     $tab = $request->query('tab'); // 例: "mylist"
        
    //     // 条件に応じてビューや処理を分岐させるなど
    //     if ($tab === 'mylist') {
    //         // マイリスト処理
    //     }
    
    //     return view('mypage.admin', compact('tab'));
    // }



    
    // public function purchase(){
    //         return view ('purchase');
    // }

    // public function sell(){
    //         return view('sell');
    // }
    
    
}

<?php

namespace App\Http\Controllers\Auth;

use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Item;
use App\Models\Sold;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\ProfileRequest;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;

class UserController extends Controller
{

    public function loginUser(LoginRequest $request){
        $credentials=$request->only('email', 'password');
        
        if(Auth::attempt($credentials)){
                    
            return redirect()->intended(RouteServiceProvider::HOME);

        } else {
            
            return back()->withErrors(['email' => 'ログイン情報が登録されていません']);
        }
    }

    // /mypageで画像のアップロード
    public function storeProfile(ProfileRequest $request)
    {
        $user = Auth::user();
        
        // 初回プロフ情報をまとめる
        $data = $request->only(['user_name', 'postcode', 'address', 'building']);

        // プロフィール写真の保存
        if ($request->hasFile('profile_image')){
            $path = $request->file('profile_image')->store('profile_images', 'public');
            $user->profile_image = $path;
        }

        // 初回プロフ情報の保存
        $user->update($data);
       

        $redirectUrl = route('mylist', ['tab' => 'mylist']);

        $request->session()->forget('url.intended');

        // プロフィール設定ページへリダイレクト
        return redirect('/mylist?tab=mylist');
    }


     public function createProfile(Request $request)
    {
        $tab = $request->query('tab', 'mylist');
        $user = Auth::user();
        $defaultUserName = $user->user_name;

        return view('auth.profile', compact('tab', 'defaultUserName'));
    }


    public function adminMypage(Request $request)
    {
        $user = Auth::user();

        $tab = $request->query('tab', 'sell');
        
        $keyword = $request->query('keyword', '');

        $query = Item::where('user_id', $user->id);

        if (!empty($keyword)) {
            $query->where('item_name', 'like', "%{$keyword}%");
        }
        $sellItems = Item::where('user_id', $user->id)->get();
        

        $boughtItems = $user->boughtItems()->get();

        return view('mylist.mypage', compact('sellItems', 'boughtItems', 'user', 'tab', 'request', 'keyword'));
    }

    public function editProfile(Request $request)
    {
        $user = Auth::user();
        $tab = $request->query('tab', 'mypage');

        return view ('mylist.edit_profile', compact('user', 'tab'));
    }

    public function updateProfile(ProfileRequest $request)
    {
        $user = Auth::user();

        $user->user_name = $request->user_name;
        $user->postcode = $request->postcode;
        $user->address = $request->address;
        $user->building = $request->building;

        if ($request->hasFile('profile_image')) {
        $path = $request->file('profile_image')->store('profile_images', 'public');
        $user->profile_image = $path;
        }

        $user->save();
        
        return redirect('mypage')->with('success', 'プロフィールを更新しました');
    }

    
}

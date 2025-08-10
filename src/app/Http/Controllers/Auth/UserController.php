<?php

namespace App\Http\Controllers\Auth;

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
    public function storeUser(RegisterRequest $request){
        $user = User::create([
            'user_name'=>$request->user_name,
            'email'=>$request->email,
            'password'=>Hash::make($request->password),
        ]);
        Auth::login($user);

        return redirect('/mypage');
    }

    public function loginUser(LoginRequest $request){
        $credentials=$request->only('email', 'password');
        
        if(Auth::attempt($credentials)){
            return redirect('/mylist?tab=mylist');
        } else {
            return back()->withErrors(['email' => '認証に失敗しました']);
        }
    }

    // /mypageで画像のアップロード
    public function upload(ProfileRequest $request)
    {
        $user = Auth::user();
        
        // 初回プロフ情報をまとめる
        $data = $request->only(['user_name', 'postcode', 'address', 'building']);

        // プロフィール写真の保存
        if ($request->hasFile('image')){
            $path = $request->file('image')->store('profile_images', 'public');
            $user->profile_image = $path;
        }

        // 初回プロフ情報の保存
        $user->update($data);
       
        // 会員ページへリダイレクト
        return redirect('/');
    }

     public function profile()
    {
        return view('auth.profile');
    }


    public function adminMypage(Request $request)
    {
        $user = Auth::user();

        $sellItems = Item::where('user_id', $user->id)->get(); 

        $boughtItems = $user->boughtItems()->get();

        $tab = $request->query('tab', 'sell');

        return view('mylist.mypage', compact('sellItems', 'boughtItems', 'user', 'tab', 'request'));
    }

    public function editProfile()
    {
        $user = Auth::user();
        return view ('mylist.edit_profile', compact('user'));
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

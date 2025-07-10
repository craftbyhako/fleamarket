<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function storeUser(RegisterRequest $request){
        $user = User::create([
            'name'=>$request->name,
            'email'=>$request->email,
            'password'=>Hash::make($request->password)
        ]);
        Auth::login($user);

        return redirect('/mypage');
    }

    public function loginUser(LoginRequest $request){
        $credentials=$request->only('email', 'password');
        if(Auth::attempt($credentials)){
            return redirect('/?tab=mylist');
        }
    }
}

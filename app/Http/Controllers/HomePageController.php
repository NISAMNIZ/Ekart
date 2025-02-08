<?php

namespace App\Http\Controllers;

use App\Http\Requests\SignUpRequest;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Validator;

class HomePageController
{

    public function login(){
        return view('users.login');
    }

    public function signUp(){
        return view('users.signUp');
    }

    public function doSignUp(SignUpRequest $request){
        $data = $request->validated();
        $data['password'] = bcrypt($data['password']);
        unset($data['confirm_password']);
        User::create($data);
        return redirect()->route('user.login');
    }

    public function doLogin()
    {
        $validator = Validator::make(request()->all(), [
            'email' => 'required|email',
            'password' => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
            }
        $input = request()->only(['email','password']);
        if(auth()->guard('web')->attempt($input))
        return redirect()->route('user.home')->with('message','Login Successful');
        else
        return response()->json(['message' => 'Invalid Credentials'], 401);
    }

    public function home(){
        $featuredProducts = Product::where('is_favorite',1)->get();
        $latestProducts = Product::orderBy('id','desc')->take(8)->get();
        $data['featuredProducts'] = $featuredProducts;
        $data['latestProducts'] = $latestProducts;
        return view('users.index',$data);
    }


    public function profile(){
        return view('users.profile');
    }

    public function logout(){
        Auth::logout();
        return redirect()->route('user.login');
    }
}

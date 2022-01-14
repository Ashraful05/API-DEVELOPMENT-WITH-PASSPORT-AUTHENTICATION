<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Author;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;


class AuthorController extends Controller
{
    public function register(Request $request)
    {
        //validate..
        $this->validate($request,[
            'name'=>'required',
            'email'=>'required|email|unique:authors',
            'phone_no'=>'required',
            'password'=>'required|confirmed'
        ]);
        //create data...
        $author = new Author();
        $author->name = $request->name;
        $author->email = $request->email;
        $author->phone_no = $request->phone_no;
        $author->password = Hash::make($request->password);
        $author->save();
        //send response...
        return response()->json([
           'status'=>1,
           'message' => 'Author Registered Successfully!!!'
        ]);
    }
    public function login(Request $request)
    {
        //validation...
        $login_data = $request->validate([
           'email'=>'required',
           'password'=>'required'
        ]);
        //validate author data...
        if(auth()->attempt($login_data)==false){
            return response()->json([
               'status'=>0,
               'message' => 'Invalid Credentials'
            ]);
        }
        //token..
        $token = auth()->user()->createToken('auth_token')->accessToken;

        //send response.......
        return response()->json([
           'status' => 1,
           'message' => 'Author LoggedIn Successfully!!!',
            'access_token' => $token
        ]);
    }
    public function profile()
    {
        $userData = auth()->user();
        return response()->json([
           'status' => 1,
           'message' => 'User Data',
            'data' => $userData
        ]);
    }
    public function logout(Request $request)
    {
        $token = $request->user()->token();
        $token->revoke();

        return response()->json([
           'status' => 1,
           'message' => 'Author LoggedOut Successfully!!!'
        ]);
    }
}

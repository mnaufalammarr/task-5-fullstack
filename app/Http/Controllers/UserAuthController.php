<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserAuthController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    //Perintah constructor ini dipergunakan untuk membatasi penggunaan controller
    //perintah $this->middleware(‘auth’) maka semua isi controller hanya bisa diakses apabila user telah login.
    //['except' => ['register','login']] untuk dilihat user umum
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['register','login']]);
    }

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'name' => 'required',
            'email'     => 'required|email',
            'password'  => 'required'
        ]);

        //jika validasi gagal
        if($validator->fails()){
            return response()->json($validator->errors(), 401);
        }

        //create user
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' =>  Hash::make($request->password)
        ]);

        $token = $user->createToken('nApp')->accessToken;
        $MessageSuccess = 'Register Success';
        return response()->json(['user'=>$user ,'message'=>$MessageSuccess, 'token'=> $token]);
        
    }
    public function login(Request $request)
    {
        $login = $request->validate([
            'email' => 'required',
            'password' => 'required'
        ]);

        if(!Auth::attempt($login)){
            $message = 'Invalid Credential';
            return response()->json($message);
        }

        $user = Auth::user();
        $token = $user->createToken('nApp')->accessToken;
        return response()->json(['user' => $user, 'token' => $token]);
    }
    
    
}

<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginUserRequest;
use App\Http\Requests\StoreUserRequest;
use App\Models\User;
use App\Traits\HttpResponses;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use PHPUnit\Framework\TestStatus\Success;

class AuthController extends Controller
{
    use HttpResponses;

    public function login(LoginUserRequest $request){

        $request->validated($request->all());

        if (!Auth::attempt($request->only(['email', 'password']))) {
           return $this->error('', 'Credntinal does not match', 401);
        }
        $user = User::where('email' , $request->email)->first();

        return $this->succes([
            'user' => $user,
            'token' => $user->createtoken('API token of' . $user->name)->plainTextToken
        ]);
    }


    public function register(StoreUserRequest $request){

        $request->validated($request->all());

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);


        return $this->succes([
            'user' => $user,
            'token' => $user->createtoken('API token of' . $user->name)->plainTextToken
        ]);
    }


    public function logout(){
       Auth::user()->currentAccessToken()->delete;
       return $this->succes('you are logged out and your token deleted succesefully');
    }
}

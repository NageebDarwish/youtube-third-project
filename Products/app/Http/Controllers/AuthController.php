<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\StoreUserRequest;
use App\Models\User;
use App\Traits\HttpResponses;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    use HttpResponses;

    public function getAll()
    {
        $users = User::all();
        return $users;
    }
    public function getbyId($id)
    {
        $obj = User::where('id', $id)->get();
        return $obj;
    }
    public function updateUser(StoreUserRequest $request)
    {
        $request->validated($request->all());
        $user = User::where('id', $request->id)->update([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);
        return $this->sucess([
            'user' => $user,
        ]);
    }

    public function remove(Request $request)
    {
        DB::table('users')->where('id', '=', $request->user_id)->delete();
    }

    public function login(LoginRequest $request)
    {
        $request->validated($request->all());

        if (!Auth::attempt($request->only(['email', 'password']))) {
            return $this->error('', 'Credentials do not match', 401);
        }
        $user = User::where('email', $request->email)->first();
        return $this->sucess([
            'user' => $user,
            'token' => $user->createToken('Api Token of' . $user->name)->plainTextToken
        ]);
    }
    public function register(StoreUserRequest $request)
    {
        $request->validated($request->all());
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);
        return $this->sucess([
            'user' => $user,
            'token' => $user->createToken('Api Token of' . $user->name)->plainTextToken
        ]);
    }
    public function logout()
    {
        Auth::user()->currentAccessToken()->delete();
        return $this->sucess([
            'message' => 'You Have Been Succesfully Logged Out'
        ]);
    }
    public function refresh(Request $request)
    {
        $user = $request->user();
        $user->tokens()->delete();
        return response()->json([
            'user' => $user,
            'token' => $user->createToken('Api Of ' . $user->name)->plainTextToken
        ]);
    }
}

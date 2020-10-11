<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\User;
use App\Http\Requests\CreateUser;

class AuthController extends Controller
{
    public function signup(CreateUser $request)
    {
        $validatedData = $request->validated();
        $user = new User([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'password' => bcrypt($validatedData['password'])
        ]);
        $user->save();
        return response('success', 201);
    }
  
    public function login(Request $request)
    {
        $validatedData = $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string'
        ]);

        if (!Auth::attempt($validatedData)) {
            return response('Unauthorized', 401);
        }
        $user = $request->user();

        $tokenResult = $user->createToken('Token');
        $tokenResult->token->save();
        return response(['token' => $tokenResult->accessToken]);
    }
  
    public function logout(Request $request)
    {
        $request->user()->token()->revoke();
        return response()->json([
            'message' => 'Successfully logged out'
        ]);
    }
  
    public function user(Request $request)
    {
        return response()->json($request->user());
    }
}

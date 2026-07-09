<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
use App\Models\User;

class AuthController extends Controller
{
 public function login(Request $request){
     $request->validate([
         'email' => 'required|string|email',
         'password' => 'required|string',
     ]);
     $user=User::where('email',$request->email)->first();
     if(!$user){
            return response()->json([
                'message' => 'User not found'
            ], 404);
     }
     if(!Hash::check($request->password, $user->password)){
         return response()->json([
             'message' => 'Invalid credentials.'
         ], 401);
     }
     $token = $user->createToken('api_token')->plainTextToken;
     return response()->json([
         'token' => $token
     ]);
 }

 public function logout(Request $request){
     $request->user()->tokens()->delete();
     return response()->json([
         'message' => 'Logged out successfully'
     ]);
 }
}

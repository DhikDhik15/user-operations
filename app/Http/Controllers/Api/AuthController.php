<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

/**
    *    @OA\Post(
    *       path="/users",
    *       tags={"Register"},
    *       operationId="register",
    *       summary="Register User",
    *       description="Register User",
    *       @OA\RequestBody(
    *           required=true,
    *           @OA\JsonContent
    *           (example={
    *               "name": "John Doe",
    *               "email": "VxqFP@example.com",
    *               "password": "password",
    *               "age": 20,
    *               "status": "active",
    *           })
    *       ),
    *       @OA\Response(
    *           response="200",
    *           description="Ok",
    *           @OA\JsonContent
    *           (example={
    *               "success": true,
    *               "message": "User created successfully",
    *               "data": {
    *                   "id": "1",
    *                   "name": "John Doe",
    *                   "email": "VxqFP@example.com",
    *                   "age": 20,
    *                   "status": "active",
    *               }
    *           }),
    *       ),
    *   )

    *    @OA\Post(
    *       path="/login",
    *       tags={"Login"},
    *       operationId="login",
    *       summary="Login User",
    *       description="Login User",
    *       @OA\RequestBody(
    *           required=true,
    *           @OA\JsonContent
    *           (example={
    *               "email": "VxqFP@example.com",
    *               "password": "password",
    *           })
    *       ),
    *       @OA\Response(
    *           response="200",
    *           description="Ok",
    *           @OA\JsonContent
    *           (example={
    *               "success": true,
    *               "message": "User logged in successfully",
    *               "data": {
    *                   "id": "1",
    *                   "name": "John Doe",
    *                   "email": "VxqFP@example.com",
    *                   "age": 20,
    *                   "status": "active",
    *               }
    *           }),
    *       ),
    *   )
    */
class AuthController extends Controller
{
    public function register(Request $request)
    {
        //set validation
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|unique:users',
            'password' => 'required',
            'age' => 'required|numeric|min:0',
            'status' => 'required',
        ]);

        //if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        // Create user
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'age' => $request->age,
            'status' => $request->status,
        ]);

        // Return response
        return response()->json([
            'message' => 'User created successfully',
            'user' => $user
        ], 201);
    }

    public function login(Request $request)
    {
        //set validation
        $validator = Validator::make($request->all(), [
            'email' => 'required',
            'password' => 'required',
        ]);

        //if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }


        //get credentials from request
        $credentials = $request->only('email', 'password');

        //if auth failed
        if(!$token = auth()->guard('api')->attempt($credentials)) {
            return response()->json([
                'success' => false,
                'message' => 'Email atau Password Anda salah'
            ], 401);
        }

        //if auth success
        return response()->json([
            'success' => true,
            'user'    => auth()->guard('api')->user(),
            'token'   => $token
        ], 200);
    }

    public function logout()
    {
        //remove token
        $removeToken = JWTAuth::invalidate(JWTAuth::getToken());
        return response()->json([
            'success' => true
        ]);
    }
}

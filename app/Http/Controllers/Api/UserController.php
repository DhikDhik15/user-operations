<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    public function profile()
    {
        return response()->json([
            'success' => true,
            'user' => auth()->user()
        ], 200);
    }

    public function allUsers()
    {
        return response()->json([
            'code' => 200,
            'success' => true,
            'users' => User::with(['role','role.role'])->paginate(5),
        ], 200);
    }

    public function userById($id)
    {
        $find = User::find($id);

        if (!$find) {
            return response()->json([
                'code' => 404,
                'success' => false,
                'message' => 'User not found',
            ], 404);
        }else{
            return response()->json([
                'code' => 200,
                'success' => true,
                'user' => User::with(['role','role.role'])->find($id),
            ], 200);
        }
    }

    public function update(Request $request, $id)
    {
        $find = User::find($id);

        if (!$find) {
            return response()->json([
                'code' => 404,
                'success' => false,
                'message' => 'User not found',
            ], 404);
        }else{
            $find->update($request->all());
            return response()->json([
                'code' => 200,
                'success' => true,
                'user' => $find,
            ], 200);
        }
    }

    public function delete($id)
    {
        $find = User::find($id);

        if (!$find) {
            return response()->json([
                'code' => 404,
                'success' => false,
                'message' => 'User not found',
            ], 404);
        }else{
            $find->delete();
            return response()->json([
                'code' => 200,
                'success' => true,
                'message' => 'User deleted',
            ], 200);
        }
    }
}

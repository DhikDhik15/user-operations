<?php

namespace App\Http\Controllers\Api;

use App\Models\RolesModel;
use Illuminate\Http\Request;
use App\Models\UserRolesModel;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class RolesController extends Controller
{
    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $role = RolesModel::create([
            'name' => $request->name,
        ]);

        return response()->json([
            'code' => 200,
            'success' => true,
            'role' => $role,
        ], 200);
    }

    public function signRoles(Request $request)
    {
        $sign = UserRolesModel::create([
            'user_id' => $request->user_id,
            'role_id' => $request->role_id
        ]);

        return response()->json([
            'code' => 200,
            'success' => true,
            'sign' => $sign,
        ], 200);
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Resources\UserData;

class UserController extends Controller
{
    public function store(Request $request)
    {
        $response = new UserData([]);
        try {
            $validator = \Validator::make($request->all(), [
                'name' => 'required|min:2|max:255',
                'email' => 'required|email|unique:users,email',
                'password' => 'required|min:3|max:25|confirmed',
            ]);

            if ($validator->fails()) {
                $response->setMessages($validator->errors()->toArray());
            }else{
                \DB::beginTransaction();
                $new_data = $request->all();
                $data = User::create($new_data);
                \DB::commit();
                $response->resource = $data;
            }

        } catch (\Throwable $th) {
            $response->setMessages([
                'error' => $th->getMessage(),
            ]);
        }

        return $response->getResponse();
    }

    public function login()
    {
        $credentials = request(['email', 'password']);

        if (! $token = auth('api')->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth('api')->factory()->getTTL() * 60
        ]);
    }

    public function show(Request $request)
    {
        return auth('api')->user();
    }

    public function logout()
    {
        auth('api')->logout();
        return [
            'status' => true,
            'data' => [],
            'message' => [],
        ];
    }
}

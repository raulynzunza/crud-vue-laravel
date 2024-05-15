<?php

namespace App\Http\Controllers;

use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{

    public function getUsers()
    {
        return User::all();
    }

    public function createUser(Request $request)
    {

        // Define validation rules
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string',
            'phone_number' => 'nullable|string',
            'city' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()->first()], 400);
        }

        $user = new User();

        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->phone_number = $request->phone_number;
        $user->city = $request->city;

        $user->save();

        return response()->json(['httpCode' => 201, 'message' => 'User created successfully'], 201);
    }

    public function updateUser(Request $request, $id)
    {
        try {
            $user = User::find($id);

            if (!$user) {
                return response()->json(['httpCode' => 404, 'message' => 'User not found'], 404);
            }
            $validator = Validator::make($request->all(), [
                'name' => 'required|string',
                'email' => 'required|email|unique:users,email,' . $id,
                'password' => 'nullable|string|min:6',
                'phone_number' => 'nullable|string',
                'city' => 'nullable|string',
            ]);

            if ($validator->fails()) {
                return response()->json(['httpCode' => 400, 'message' => $validator->errors()->first()], 400);
            }

            $user->name = $request->name;
            $user->email = $request->email;
            $user->phone_number = $request->phone_number;
            $user->city = $request->city;

            $user->save();

            return response()->json(['httpCode' => 200, 'message' => 'User updated successfully'], 200);
        } catch (Exception $e) {
            return response()->json(['httpCode' => 500, 'message' => $e->getMessage()], 500);
        }
    }


    public function deleteUser($id)
    {
        $user = User::find($id);

        $user->delete();

        return response()->json(['httpCode' => 200, 'message' => 'User deleted successfully'], 200);
    }

    public function getSpecificUser($id)
    {
        $user = User::find($id);

        if ($user) {
            return response()->json(['message' => 'User exist', 'user' => $user], 200);
        } else {
            return response()->json(['message' => 'User does not exist with thhe id: ' . $id], 400);
        }
    }
}

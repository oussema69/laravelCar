<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Validator;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class RoleController extends Controller
{
    public function getUsersByRole($role)
    {
        $users = User::where('role', $role)->get();
        return response()->json([
            'users' => $users
        ]);
    }
    public function deleteUser($id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json([
                'message' => 'User not found'
            ], 404);
        }

        if (!$user->delete()) {
            return response()->json([
                'message' => 'Error deleting user'
            ], 500);
        }

        return response()->json([
            'message' => 'User deleted successfully'
        ]);
    }
public function updateUser(Request $request, $id)
{
    $user = User::findOrFail($id);

    $validator = Validator::make($request->all(), [
        'nom' => 'string|max:255',
        'prenom' => 'string|max:255',
        'email' => 'string|email|max:255|unique:users,email,'.$user->id,
        'password' => 'string|min:6|max:255',
        'tel' => 'string|max:10',
        'role' => 'integer',
    ]);

    if ($validator->fails()) {
        return response()->json(['error' => ['message' => $validator->errors()->first()]]);
    }

    $user->nom = $request->nom;
    $user->prenom = $request->prenom;
    $user->email = $request->email;
    $user->password = bcrypt($request->password);
    $user->tel = $request->tel;
    $user->role = $request->role;

    $user->save();

    return response()->json(['message' => 'User updated successfully', 'user' => $user]);
}

    public function getUserById($id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json([
                'message' => 'User not found'
            ], 404);
        }

        return response()->json([
            'user' => $user
        ]);
    }
}

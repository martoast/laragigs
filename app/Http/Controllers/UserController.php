<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
        return response()->json($users);
    }

    public function show(string $id)
    {
        $user = User::findOrFail($id);
        return response()->json($user);
    }

    public function update(Request $request, string $id)
{
    $user = User::findOrFail($id);

    $rules = [
        'email' => 'required',
        'name' => 'required',
        'password' => 'required',
    ];

    $messages = [
        'email.required' => 'The email field is required.',
        'name.required' => 'The name field is required.',
        'password.required' => 'The password field is required.',
    ];

    $validator = Validator::make($request->all(), $rules, $messages);

    if ($validator->fails()) {
        return response()->json([
            'errors' => $validator->errors()
        ], 422);
    }

    $user->name = $request->input('name');
    $user->email = $request->input('email');

    if ($request->has('password')) {
        $user->password = bcrypt($request->input('password'));
    }

    $user->save();

    return response()->json([
        'message' => 'User updated successfully',
        'user' => $user
    ]);
}
    
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function profile()
    {
        return Auth::user();
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();
        $request->validate([
            'name' => 'string',
            'email' => 'email|unique:users,email,' . $user->id,
        ]);
        $user->update($request->all());
        return $user;
    }
}
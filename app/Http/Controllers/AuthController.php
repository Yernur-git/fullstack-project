<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Role;

class AuthController extends Controller
{
    public function show()
    {
        return view('pages.auth');
    }

    public function login(Request $request)
    {
        $user = User::where('email', $request->username)
                    ->orWhere('name', $request->username)
                    ->first();

        if ($user && Hash::check($request->password, $user->password)) {
            session([
                'logged_in' => true,
                'user_id' => $user->id,
                'user_name' => $user->name,
                'user_email' => $user->email,
                'user_role' => $user->role?->name,
            ]);
            return redirect()->route('home')->with('success', __('Welcome, :name!', ['name' => $user->name]));
        }

        return redirect()->route('midterm')->with('error', __('Invalid username or password'));
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:users,name',
            'email' => 'required|email|max:255|unique:users,email',
            'password' => 'required|string|min:6',
        ]);

        $role = Role::where('name', 'viewer')->first() ?? Role::first();

        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->role_id = $role?->id;
        $user->save();

        session([
            'logged_in' => true,
            'user_id' => $user->id,
            'user_name' => $user->name,
            'user_email' => $user->email,
            'user_role' => $user->role?->name ?? 'viewer',
        ]);

        return redirect()->route('home')->with('success', __('Account created successfully.'));
    }

    public function logout()
    {
        session()->forget(['logged_in', 'user_id', 'user_name', 'user_email', 'user_role']);
        return redirect()->route('home');
    }

    public function changeRole(Request $request)
{
    if (session('user_role') !== 'admin') {
        return response()->json(['error' => 'Unauthorized'], 403);
    }

    $user = User::findOrFail($request->user_id);
    $role = \App\Models\Role::where('name', $request->role)->firstOrFail();
    $user->role_id = $role->id;
    $user->save();

    if (!$request->expectsJson()) {
        return redirect()->route('profile')->with('success', __('Role updated successfully.'));
    }

    return response()->json(['success' => true]);
}
}

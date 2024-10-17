<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    public function edit()
    {
        return view('role-permission.user.profile', ['user' => auth()->user()]);
    }

    public function update(Request $request)
    {
        $user = auth()->user();

        $validatedData = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
        ]);
        $validatedData = $request->only(['name', 'email']);

        if ($request->filled('password')) {
            $validatedData['password'] = Hash::make($request->input('password'));
        }

        $user->update($validatedData);

        return redirect()->route('users.index')
            ->with('success', 'Profile updated successfully.');
    }
}

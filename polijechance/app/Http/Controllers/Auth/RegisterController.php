<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Kelas;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    public function show()
{
    $kelas = Kelas::all();
    return view('auth.custom-register', compact('kelas'));
}

public function store(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:users',
        'password' => 'required|string|min:8|confirmed',
        'kelas_id' => 'required|exists:kelas,id',
    ]);

    $user = User::create([
        'name' => $request->name,
        'email' => $request->email,
        'kelas_id' => $request->kelas_id,
        'password' => Hash::make($request->password),
    ]);

    Auth::login($user); // langsung login setelah register
    return redirect()->route('dashboard');
}
}

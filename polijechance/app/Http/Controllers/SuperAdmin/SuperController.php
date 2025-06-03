<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;

class SuperController extends Controller
{
    public function show()
    {
        $admins = Admin::all();
        return view('super-admin.super', compact('admins'));
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:admins,email',
            'password' => 'required|min:6',
        ]);
    
        Admin::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);
    
        return redirect()->route('admin.store')->with('success', 'Admin berhasil ditambahkan');
    }
    
    public function destroy($id)
    {
        Admin::findOrFail($id)->delete();
        return redirect()->route('admin.destroy')->with('success', 'Admin berhasil dihapus');
    }
}

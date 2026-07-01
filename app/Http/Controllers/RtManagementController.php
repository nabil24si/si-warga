<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class RtManagementController extends Controller
{
    public function index()
    {
        $rtUsers = User::where('role', 'rt')->latest()->get();
        return view('rt-management.index', compact('rtUsers'));
    }

    public function create()
    {
        return view('rt-management.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'rt_number' => [
                'required',
                'string',
                Rule::unique('users')->where(function ($query) {
                    return $query->where('role', 'rt')->whereNull('deleted_at');
                }),
            ],
            'password' => 'required|string|min:8',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'rt',
            'rt_number' => $request->rt_number,
            'status_akun' => 'aktif',
        ]);

        return redirect()->route('rt-management.index')->with('success', 'Akun RT berhasil ditambahkan.');
    }

    public function edit(User $rt_management)
    {
        return view('rt-management.edit', ['user' => $rt_management]);
    }

    public function update(Request $request, User $rt_management)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $rt_management->id,
            'rt_number' => [
                'required',
                'string',
                Rule::unique('users')->where(function ($query) {
                    return $query->where('role', 'rt')->whereNull('deleted_at');
                })->ignore($rt_management->id),
            ],
            'password' => 'nullable|string|min:8',
        ]);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'rt_number' => $request->rt_number,
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $rt_management->update($data);

        return redirect()->route('rt-management.index')->with('success', 'Akun RT berhasil diperbarui.');
    }

    public function destroy(User $rt_management)
    {
        $name = $rt_management->name;
        $rt_management->delete(); // Soft delete
        return redirect()->route('rt-management.index')->with('success', 'Akun ' . $name . ' berhasil dihapus (Akses dicabut secara permanen).');
    }
}

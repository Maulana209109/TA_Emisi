<?php

namespace App\Http\Controllers\Api; // <--- UPDATE NAMESPACE

use App\Http\Controllers\Controller; // <--- WAJIB IMPORT INI
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
        return response()->json([
            'success' => true,
            'message' => 'Daftar semua user berhasil diambil',
            'data' => $users
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'role' => 'nullable|in:admin,user',
            'dailyCarbonLimit' => 'nullable|numeric',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role ?? 'user',
            'dailyCarbonLimit' => $request->dailyCarbonLimit ?? 0,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'User baru berhasil dibuat',
            'data' => $user
        ], 201);
    }

    public function show($id = null)
    {
        if ($id === null || $id === 'me') {
            $user = Auth::user();
        } else {
            $user = User::find($id);
        }

        if (!$user) return response()->json(['success' => false, 'message' => 'User tidak ditemukan'], 404);

        return response()->json([
            'success' => true,
            'message' => 'Detail user ditemukan',
            'data' => $user
        ]);
    }

    public function update(Request $request, $id = null)
    {
        if ($id === null || $id === 'me') {
            $user = Auth::user();
        } else {
            $user = User::find($id);
        }

        if (!$user) return response()->json(['success' => false, 'message' => 'User tidak ditemukan'], 404);

        $request->validate([
            'name' => 'nullable|string|max:255',
            'email' => 'nullable|email|unique:users,email,' . $user->id,
            'password' => 'nullable|min:6',
            'profileImage' => 'nullable|image|max:2048',
            'dailyCarbonLimit' => 'nullable|numeric',
            'dateOfBirth' => 'nullable|date',
        ]);

        if ($request->hasFile('profileImage')) {
            if ($user->profileImage) Storage::disk('public')->delete($user->profileImage);
            $path = $request->file('profileImage')->store('profile_images', 'public');
            $user->profileImage = $path;
        }

        if ($request->has('name')) $user->name = $request->name;
        if ($request->has('email')) $user->email = $request->email;
        if ($request->has('dailyCarbonLimit')) $user->dailyCarbonLimit = $request->dailyCarbonLimit;
        if ($request->has('dateOfBirth')) $user->dateOfBirth = $request->dateOfBirth;

        if ($request->has('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return response()->json([
            'success' => true,
            'message' => 'Data user berhasil diperbarui',
            'data' => $user
        ]);
    }

    public function destroy($id)
    {
        $user = User::find($id);
        if (!$user) return response()->json(['success' => false, 'message' => 'User tidak ditemukan'], 404);

        if ($user->profileImage) Storage::disk('public')->delete($user->profileImage);
        $user->delete();

        return response()->json(['success' => true, 'message' => 'User berhasil dihapus']);
    }
}

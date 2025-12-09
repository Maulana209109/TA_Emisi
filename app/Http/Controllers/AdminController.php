<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
    {
        // Mengambil semua data user, diurutkan dari yang terbaru
        $users = User::latest()->get();

        return view('pages.admin.dashboard', compact('users'));
    }
}

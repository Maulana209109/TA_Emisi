<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\EmissionCategory;
use App\Models\EmissionFactor;
use App\Models\ConsumptionEntry;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    /**
     * TAMPILAN DASHBOARD UTAMA
     * Mengambil data untuk Statistik, Grafik, dan Tabel
     */
    public function dashboard()
    {
        // --- 1. DATA KARTU STATISTIK (STATS CARDS) ---

        // Kartu 1: Traffic (Total Konsumsi Emisi User)
        $totalEntries = ConsumptionEntry::count();

        // Kartu 2: New Users (Total User terdaftar)
        $totalUsers = User::count();
        $newUsersThisMonth = User::whereMonth('created_at', date('m'))
            ->whereYear('created_at', date('Y'))
            ->count();

        // Kartu 3: Sales (Total Faktor Emisi yang tersedia)
        $totalFactors = EmissionFactor::count();

        // Kartu 4: Performance (Total Kategori)
        $totalCategories = EmissionCategory::count();


        // --- 2. DATA GRAFIK (CHARTS) ---

        // Grafik 1: Line Chart (Tren Input User per Bulan Tahun Ini)
        $entriesData = $this->getMonthlyData(ConsumptionEntry::class);

        // Grafik 2: Bar Chart (Registrasi User Baru per Bulan Tahun Ini)
        $usersData = $this->getMonthlyData(User::class);


        // --- 3. DATA TABEL (TABLES) ---

        // Tabel 1: Top 5 User Paling Aktif Menginput
        $topUsers = User::withCount('consumptionEntries')
            ->orderBy('consumption_entries_count', 'desc')
            ->take(5)
            ->get();

        // Tabel 2: Sebaran Kategori Emisi
        $categoriesStats = EmissionCategory::withCount('factors')
            ->orderBy('factors_count', 'desc')
            ->take(5)
            ->get();

        // Kirim semua data ke view
        return view('pages.admin.dashboard', compact(
            'totalEntries',
            'totalUsers',
            'newUsersThisMonth',
            'totalFactors',
            'totalCategories',
            'entriesData',
            'usersData',
            'topUsers',
            'categoriesStats'
        ));
    }

    /**
     * Helper untuk mengambil data bulanan (Jan-Des)
     */
    private function getMonthlyData($modelClass)
    {
        $currentYear = date('Y');

        // Query group by month
        $data = $modelClass::select(
            DB::raw('COUNT(*) as count'),
            DB::raw('MONTH(created_at) as month')
        )
            ->whereYear('created_at', $currentYear)
            ->groupBy('month')
            ->pluck('count', 'month')
            ->toArray();

        // Format array agar selalu ada 12 bulan (isi 0 jika kosong)
        $result = [];
        for ($i = 1; $i <= 12; $i++) {
            $result[] = $data[$i] ?? 0;
        }

        return $result;
    }

    // =================================================================
    // CRUD USER MANAGEMENT
    // =================================================================

    public function userIndex()
    {
        $users = User::latest()->paginate(10);
        return view('pages.admin.users.index', compact('users'));
    }

    public function userStore(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
            'role' => 'required'
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role
        ]);

        return redirect()->back()->with('success', 'User berhasil ditambahkan');
    }

    public function userUpdate(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $id,
        ]);

        $data = $request->only(['name', 'email', 'role']);
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return redirect()->back()->with('success', 'User berhasil diupdate');
    }

    public function userDestroy($id)
    {
        User::findOrFail($id)->delete();
        return redirect()->back()->with('success', 'User berhasil dihapus');
    }

    // =================================================================
    // CRUD EMISSION CATEGORY
    // =================================================================

    public function categoryIndex()
    {
        $categories = EmissionCategory::withCount('factors')->latest()->paginate(10);
        return view('pages.admin.categories.index', compact('categories'));
    }

    public function categoryStore(Request $request)
    {
        $request->validate([
            'category_name' => 'required|unique:emission_categories,category_name'
        ]);

        EmissionCategory::create([
            'category_name' => $request->category_name
        ]);

        return redirect()->back()->with('success', 'Kategori berhasil ditambahkan');
    }

    public function categoryUpdate(Request $request, $id)
    {
        $category = EmissionCategory::findOrFail($id);

        $request->validate([
            'category_name' => 'required|unique:emission_categories,category_name,' . $id
        ]);

        $category->update([
            'category_name' => $request->category_name
        ]);

        return redirect()->back()->with('success', 'Kategori berhasil diupdate');
    }

    public function categoryDestroy($id)
    {
        EmissionCategory::findOrFail($id)->delete();
        return redirect()->back()->with('success', 'Kategori berhasil dihapus');
    }

    // =================================================================
    // CRUD EMISSION FACTORS
    // =================================================================

    public function factorIndex(Request $request)
    {
        $categories = EmissionCategory::all();

        $factors = EmissionFactor::with('category')
            ->when($request->category, function ($query) use ($request) {
                return $query->where('factor_category_id', $request->category);
            })
            ->latest()
            ->paginate(10);

        return view('pages.admin.factors.index', compact('factors', 'categories'));
    }

    public function factorStore(Request $request)
    {
        $request->validate([
            'factor_category_id' => 'required|exists:emission_categories,id',
            'name' => 'required',
            'value' => 'required|numeric'
        ]);

        EmissionFactor::create([
            'factor_category_id' => $request->factor_category_id,
            'name' => $request->name,
            'value' => $request->value
        ]);

        return redirect()->back()->with('success', 'Faktor Emisi berhasil ditambahkan');
    }

    public function factorUpdate(Request $request, $id)
    {
        $factor = EmissionFactor::findOrFail($id);

        $request->validate([
            'factor_category_id' => 'required|exists:emission_categories,id',
            'name' => 'required',
            'value' => 'required|numeric'
        ]);

        $factor->update([
            'factor_category_id' => $request->factor_category_id,
            'name' => $request->name,
            'value' => $request->value
        ]);

        return redirect()->back()->with('success', 'Faktor Emisi berhasil diupdate');
    }

    public function factorDestroy($id)
    {
        EmissionFactor::findOrFail($id)->delete();
        return redirect()->back()->with('success', 'Faktor Emisi berhasil dihapus');
    }
}

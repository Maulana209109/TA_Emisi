<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\EmissionCategory;
use App\Models\EmissionFactor;
use App\Models\ConsumptionEntry;
use App\Services\KpiDashboardService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function __construct(private KpiDashboardService $kpiDashboard) {}

    /**
     * TAMPILAN DASHBOARD UTAMA
     * Mengambil data KPI Balanced Scorecard, grafik, dan tabel detail.
     */
    public function dashboard(Request $request)
    {
        $data = $this->kpiDashboard->build(
            $request->query('from'),
            $request->query('to'),
            $request->query('perspective')
        );

        return view('pages.admin.dashboard', compact('data'));
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

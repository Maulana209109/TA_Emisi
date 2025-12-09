<?php

namespace App\Http\Controllers;

use App\Models\ConsumptionEntry;
use App\Models\EmissionFactor;
use App\Models\EmissionCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EmissionWebController extends Controller
{
    // Halaman Utama Dashboard Emisi
    public function dashboard()
    {
        $user = Auth::user();

        // Menghitung total emisi hari ini
        $todayEmission = ConsumptionEntry::where('user_id', $user->id)
            ->whereDate('entry_date', now())
            ->sum('emissions');

        // Mengambil 5 histori terakhir
        $recentEntries = ConsumptionEntry::where('user_id', $user->id)
            ->with('emissionFactor') // Eager loading
            ->latest()
            ->take(5)
            ->get();

        return view('pages.emission.dashboard', compact('user', 'todayEmission', 'recentEntries'));
    }

    // Halaman Form Tambah Data
    public function create()
    {
        // Kita butuh data faktor emisi untuk dropdown
        $categories = EmissionCategory::with('factors')->get();
        return view('pages.emission.create', compact('categories'));
    }

    // Proses Simpan Data (Action Form)
    public function store(Request $request)
    {
        $request->validate([
            'factor_items_id' => 'required|exists:emission_factors,id',
            'quantity' => 'required|numeric|min:0',
            'entry_date' => 'required|date',
        ]);

        $factor = EmissionFactor::find($request->factor_items_id);
        $emissions = $request->quantity * $factor->value;

        ConsumptionEntry::create([
            'user_id' => Auth::id(),
            'factor_items_id' => $request->factor_items_id,
            'entry_date' => $request->entry_date,
            'emissions' => $emissions,
            'quantity' => $request->quantity,
            // Simpan metadata sederhana jika perlu
            'metadata' => ['source' => 'web_input'],
        ]);

        return redirect()->route('emission.dashboard')->with('success', 'Data konsumsi berhasil dicatat!');
    }

    // Halaman Riwayat Lengkap
    public function history()
    {
        $entries = ConsumptionEntry::where('user_id', Auth::id())
            ->with('emissionFactor')
            ->latest()
            ->paginate(10); // Pakai pagination agar rapi

        return view('pages.emission.history', compact('entries'));
    }
}

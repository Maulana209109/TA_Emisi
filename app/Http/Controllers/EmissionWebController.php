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

        // Total emisi hari ini
        $todayEmission = ConsumptionEntry::where('user_id', $user->id)
            ->whereDate('entry_date', now())
            ->sum('emissions');

        // 5 histori terakhir (eager load faktor + kategorinya)
        $recentEntries = ConsumptionEntry::where('user_id', $user->id)
            ->with(['emissionFactor', 'emissionFactor.category'])
            ->latest()
            ->take(5)
            ->get();

        // Data Grafik Konsumsi 7 Hari Terakhir
        $chartLabels = [];
        $chartData = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = \Carbon\Carbon::today()->subDays($i)->format('Y-m-d');
            $chartLabels[] = \Carbon\Carbon::parse($date)->translatedFormat('d M');
            $total = ConsumptionEntry::where('user_id', $user->id)
                ->whereDate('entry_date', $date)
                ->sum('emissions');
            $chartData[] = round($total, 2);
        }

        return view('pages.emission.dashboard', compact('user', 'todayEmission', 'recentEntries', 'chartLabels', 'chartData'));
    }

    // Halaman Form Tambah Data
    public function create()
    {
        $categories = EmissionCategory::with('factors')->get();
        return view('pages.emission.create', compact('categories'));
    }

    // Proses Simpan Data
    public function store(Request $request)
    {
        $request->validate([
            'factor_items_id' => 'required|exists:emission_factors,id',
            'quantity'        => 'required|numeric|min:0.01',
            'entry_date'      => 'required|date',
        ]);

        $factor    = EmissionFactor::findOrFail($request->factor_items_id);
        $emissions = $request->quantity * $factor->value;

        ConsumptionEntry::create([
            'user_id'         => Auth::id(),
            'factor_items_id' => $request->factor_items_id,
            'entry_date'      => $request->entry_date,
            'emissions'       => $emissions,
            'quantity'        => $request->quantity,
            'metadata'        => ['source' => 'web_input'],
        ]);

        return redirect()
            ->route('emission.dashboard')
            ->with('success', 'Data konsumsi berhasil dicatat!');
    }

    // Halaman Riwayat Lengkap
    public function history()
    {
        $entries = ConsumptionEntry::where('user_id', Auth::id())
            ->with(['emissionFactor', 'emissionFactor.category'])
            ->latest()
            ->paginate(15);

        return view('pages.emission.history', compact('entries'));
    }
}

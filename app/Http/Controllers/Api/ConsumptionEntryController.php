<?php

namespace App\Http\Controllers\Api; // <--- UPDATE NAMESPACE

use App\Http\Controllers\Controller; // <--- WAJIB IMPORT INI
use App\Models\ConsumptionEntry;
use App\Models\EmissionFactor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ConsumptionEntryController extends Controller
{
    public function index()
    {
        $entries = ConsumptionEntry::where('user_id', Auth::id())
            ->with('emissionFactor')
            ->latest()
            ->get();

        return response()->json(['success' => true, 'data' => $entries]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'factor_items_id' => 'required|exists:emission_factors,id',
            'quantity' => 'required|numeric|min:0',
            'entry_date' => 'required|date',
            'image' => 'nullable|image|max:2048',
            'metadata' => 'nullable|array',
        ]);

        $factor = EmissionFactor::find($request->factor_items_id);
        $calculatedEmissions = $request->quantity * $factor->value;

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('consumption_images', 'public');
        }

        $entry = ConsumptionEntry::create([
            'user_id' => Auth::id(),
            'factor_items_id' => $request->factor_items_id,
            'entry_date' => $request->entry_date,
            'emissions' => $calculatedEmissions,
            'quantity' => $request->quantity,
            'image' => $imagePath,
            'metadata' => $request->metadata,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Data konsumsi berhasil ditambahkan',
            'data' => $entry
        ], 201);
    }

    public function show($id)
    {
        $entry = ConsumptionEntry::where('user_id', Auth::id())->with('emissionFactor')->find($id);
        if (!$entry) return response()->json(['success' => false, 'message' => 'Data tidak ditemukan'], 404);
        return response()->json(['success' => true, 'data' => $entry]);
    }

    public function update(Request $request, $id)
    {
        $entry = ConsumptionEntry::where('user_id', Auth::id())->find($id);
        if (!$entry) return response()->json(['success' => false, 'message' => 'Data tidak ditemukan'], 404);

        $entry->update($request->only(['quantity', 'entry_date', 'metadata']));

        if ($request->has('quantity')) {
            $factor = $entry->emissionFactor;
            $entry->emissions = $request->quantity * $factor->value;
            $entry->save();
        }

        return response()->json(['success' => true, 'message' => 'Data diperbarui', 'data' => $entry]);
    }

    public function destroy($id)
    {
        $entry = ConsumptionEntry::where('user_id', Auth::id())->find($id);
        if (!$entry) return response()->json(['success' => false, 'message' => 'Data tidak ditemukan'], 404);
        $entry->delete();
        return response()->json(['success' => true, 'message' => 'Data dihapus']);
    }
}

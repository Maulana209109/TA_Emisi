<?php

namespace App\Http\Controllers\Api; // <--- UPDATE NAMESPACE

use App\Http\Controllers\Controller; // <--- WAJIB IMPORT INI
use App\Models\EmissionFactor;
use Illuminate\Http\Request;

class EmissionFactorController extends Controller
{
    public function index(Request $request)
    {
        $query = EmissionFactor::query();

        if ($request->has('category_id')) {
            $query->where('factor_category_id', $request->category_id);
        }

        return response()->json([
            'success' => true,
            'message' => 'Daftar faktor emisi berhasil diambil',
            'data' => $query->get()
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'factor_category_id' => 'required|exists:emission_categories,id',
            'name' => 'required|string',
            'value' => 'required|numeric',
        ]);

        $factor = EmissionFactor::create($request->all());
        return response()->json(['success' => true, 'data' => $factor], 201);
    }

    public function show($id)
    {
        $factor = EmissionFactor::with('category')->find($id);
        if (!$factor) return response()->json(['success' => false, 'message' => 'Tidak ditemukan'], 404);
        return response()->json(['success' => true, 'data' => $factor]);
    }

    public function update(Request $request, $id)
    {
        $factor = EmissionFactor::find($id);
        if (!$factor) return response()->json(['success' => false, 'message' => 'Tidak ditemukan'], 404);
        $factor->update($request->all());
        return response()->json(['success' => true, 'data' => $factor]);
    }

    public function destroy($id)
    {
        $factor = EmissionFactor::find($id);
        if (!$factor) return response()->json(['success' => false, 'message' => 'Tidak ditemukan'], 404);
        $factor->delete();
        return response()->json(['success' => true, 'message' => 'Data dihapus']);
    }
}

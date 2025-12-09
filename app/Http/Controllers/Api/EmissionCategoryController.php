<?php

namespace App\Http\Controllers\Api; // <--- UPDATE NAMESPACE

use App\Http\Controllers\Controller; // <--- WAJIB IMPORT INI
use App\Models\EmissionCategory;
use Illuminate\Http\Request;

class EmissionCategoryController extends Controller
{
    public function index()
    {
        $categories = EmissionCategory::all();
        return response()->json([
            'success' => true,
            'message' => 'Daftar kategori berhasil diambil',
            'data' => $categories
        ]);
    }

    public function store(Request $request)
    {
        $request->validate(['category_name' => 'required|string|max:255']);
        $category = EmissionCategory::create($request->all());
        return response()->json(['success' => true, 'data' => $category], 201);
    }

    public function show($id)
    {
        $category = EmissionCategory::find($id);
        if (!$category) return response()->json(['success' => false, 'message' => 'Tidak ditemukan'], 404);
        return response()->json(['success' => true, 'data' => $category]);
    }

    public function update(Request $request, $id)
    {
        $category = EmissionCategory::find($id);
        if (!$category) return response()->json(['success' => false, 'message' => 'Tidak ditemukan'], 404);

        $category->update($request->all());
        return response()->json(['success' => true, 'message' => 'Update berhasil', 'data' => $category]);
    }

    public function destroy($id)
    {
        $category = EmissionCategory::find($id);
        if (!$category) return response()->json(['success' => false, 'message' => 'Tidak ditemukan'], 404);
        $category->delete();
        return response()->json(['success' => true, 'message' => 'Data dihapus']);
    }
}

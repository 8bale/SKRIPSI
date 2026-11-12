<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Rack;
use Illuminate\Http\Request;

/**
 * BarangController
 * Mengelola CRUD data barang spare part inventaris mekanik.
 */
class BarangController extends Controller
{
    /**
     * Menampilkan daftar seluruh barang inventaris beserta rak penyimpanannya.
     */
    public function index()
    {
        $barangs = Barang::with('rack')->latest()->get();

        return view('barang.index', compact('barangs'));
    }

    /**
     * Menampilkan formulir tambah barang baru.
     */
    public function create()
    {
        $racks = Rack::all();

        return view('barang.create', compact('racks'));
    }

    /**
     * Menyimpan data barang baru ke database.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_barang' => 'required|string|max:255',
            'deskripsi'   => 'nullable|string',
            'id_rack'     => 'required|exists:rack,id_rack',
            'stock'       => 'required|integer|min:0',
        ]);

        Barang::create($validated);

        return redirect()->route('barang.index')
            ->with('success', 'Barang berhasil ditambahkan ke inventaris.');
    }

    /**
     * Menampilkan formulir edit barang.
     */
    public function edit(string $id_barang)
    {
        $barang = Barang::findOrFail($id_barang);
        $racks  = Rack::all();

        return view('barang.edit', compact('barang', 'racks'));
    }

    /**
     * Memperbarui data barang di database.
     */
    public function update(Request $request, string $id_barang)
    {
        $validated = $request->validate([
            'nama_barang' => 'required|string|max:255',
            'deskripsi'   => 'nullable|string',
            'id_rack'     => 'required|exists:rack,id_rack',
            'stock'       => 'required|integer|min:0',
        ]);

        $barang = Barang::findOrFail($id_barang);
        $barang->update($validated);

        return redirect()->route('barang.index')
            ->with('success', 'Data barang berhasil diperbarui.');
    }

    /**
     * Menghapus data barang dari database.
     */
    public function destroy(string $id_barang)
    {
        $barang = Barang::find($id_barang);

        if (!$barang) {
            return redirect()->route('barang.index')
                ->with('error', 'Barang tidak ditemukan.');
        }

        $namaBarang = $barang->nama_barang;
        $barang->delete();

        return redirect()->route('barang.index')
            ->with('success', "Barang '{$namaBarang}' berhasil dihapus dari inventaris.");
    }
}

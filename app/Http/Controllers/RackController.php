<?php

namespace App\Http\Controllers;

use App\Models\Rack;
use Illuminate\Http\Request;

/**
 * RackController
 * Mengelola katalog data titik rak dan zonasi penyimpanan spare part.
 */
class RackController extends Controller
{
    /**
     * Menampilkan daftar seluruh rak penyimpanan beserta jumlah barang tersimpan.
     */
    public function index()
    {
        $racks = Rack::withCount('barangs')->orderBy('nama_rack', 'asc')->get();

        return view('Rack.index', compact('racks'));
    }

    /**
     * Menampilkan formulir penambahan rak baru.
     */
    public function create()
    {
        $existingRacks = Rack::orderBy('nama_rack', 'asc')->get();

        return view('Rack.create', compact('existingRacks'));
    }

    /**
     * Menyimpan data rak baru ke database.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nama_rack' => 'required|string|max:255|unique:rack,nama_rack',
            'lokasi'    => 'required|string|max:255',
        ], [
            'nama_rack.required' => 'Nama rak wajib diisi.',
            'nama_rack.unique'   => 'Nama rak ini sudah terdaftar sebelumnya.',
            'lokasi.required'    => 'Lokasi / zona gudang wajib diisi.',
        ]);

        Rack::create($validatedData);

        return redirect()->route('rack.index')
            ->with('success', 'Rak penyimpanan baru berhasil ditambahkan.');
    }

    /**
     * Menampilkan formulir edit rak.
     */
    public function edit(string $id_rack)
    {
        $rack = Rack::withCount('barangs')->findOrFail($id_rack);

        return view('Rack.edit', compact('rack'));
    }

    /**
     * Memperbarui data rak di database.
     */
    public function update(Request $request, string $id_rack)
    {
        $rack = Rack::findOrFail($id_rack);

        $validatedData = $request->validate([
            'nama_rack' => 'required|string|max:255|unique:rack,nama_rack,' . $id_rack . ',id_rack',
            'lokasi'    => 'required|string|max:255',
        ], [
            'nama_rack.required' => 'Nama rak wajib diisi.',
            'nama_rack.unique'   => 'Nama rak ini sudah digunakan oleh rak lain.',
            'lokasi.required'    => 'Lokasi / zona gudang wajib diisi.',
        ]);

        $rack->update($validatedData);

        return redirect()->route('rack.index')
            ->with('success', 'Data rak penyimpanan berhasil diperbarui.');
    }

    /**
     * Menghapus rak dari database (dengan validasi perlindungan relasi barang).
     */
    public function destroy(string $id_rack)
    {
        $rack = Rack::withCount('barangs')->findOrFail($id_rack);

        // Safeguard: Rak tidak boleh dihapus jika masih ada barang yang menempatinya
        if ($rack->barangs_count > 0) {
            return redirect()->route('rack.index')->with(
                'error',
                "Rak '{$rack->nama_rack}' tidak dapat dihapus karena masih menyimpan {$rack->barangs_count} item barang. Silakan pindahkan barang ke rak lain terlebih dahulu."
            );
        }

        $namaRack = $rack->nama_rack;
        $rack->delete();

        return redirect()->route('rack.index')
            ->with('success', "Rak '{$namaRack}' berhasil dihapus.");
    }
}

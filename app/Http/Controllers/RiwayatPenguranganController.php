<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\RiwayatPengurangan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/**
 * RiwayatPenguranganController
 * Menangani transaksi pengambilan suku cadang dan pemotongan stok secara atomik.
 */
class RiwayatPenguranganController extends Controller
{
    /**
     * Menampilkan daftar riwayat pengambilan suku cadang.
     * - Administrator: melihat log seluruh transaksi mekanik.
     * - User/Staff: hanya melihat catatan riwayat yang dibuat oleh akunnya sendiri.
     */
    public function index()
    {
        $user = auth()->user();
        $query = RiwayatPengurangan::with(['barang.rack', 'user']);

        if (!$user->isAdmin()) {
            $query->where('user_id', $user->id);
        }

        $riwayats = $query->latest('tanggal_ambil')->get();
        $totalItemDiambil = $riwayats->sum('jumlah');

        return view('Pengurangan.index', compact('riwayats', 'totalItemDiambil'));
    }

    /**
     * Menampilkan formulir pengambilan suku cadang.
     */
    public function create(string $id_barang)
    {
        $barang = Barang::with('rack')->findOrFail($id_barang);

        // Validasi ketersediaan stok
        if ($barang->stock <= 0) {
            return redirect()->route('barang.index')
                ->with('error', "Stok barang '{$barang->nama_barang}' saat ini habis (0 unit), tidak dapat melakukan pengambilan.");
        }

        return view('Pengurangan.create', compact('barang'));
    }

    /**
     * Memproses pengambilan barang dan memotong stok gudang dengan Database Transaction.
     */
    public function store(Request $request, string $id_barang)
    {
        $barang = Barang::findOrFail($id_barang);

        $validatedData = $request->validate([
            'jumlah'        => ['required', 'integer', 'min:1'],
            'nama_mekanik'  => ['required', 'string', 'max:255'],
            'shift'         => ['required', 'string', 'in:Shift 1,Shift 2,Shift 3,Non-Shift,Regu 1,Regu 2,Regu 3,Shift 1 (Pagi),Shift 2 (Sore),Shift 3 (Malam),Non-Shift / Day'],
            'keperluan'     => ['required', 'string', 'max:500'],
            'tanggal_ambil' => ['nullable', 'date'],
        ], [
            'jumlah.required'       => 'Jumlah barang yang diambil wajib diisi.',
            'jumlah.integer'        => 'Jumlah harus berupa bilangan bulat positif.',
            'jumlah.min'            => 'Jumlah pengambilan minimal 1 unit.',
            'nama_mekanik.required' => 'Nama teknisi / mekanik pengambil wajib diisi.',
            'shift.required'        => 'Shift kerja wajib dipilih.',
            'shift.in'              => 'Pilihan shift kerja tidak valid.',
            'keperluan.required'    => 'Note / keterangan keperluan wajib diisi.',
        ]);

        // Validasi stok fisik mencukupi
        if ($validatedData['jumlah'] > $barang->stock) {
            return back()->withErrors([
                'jumlah' => "Jumlah yang diambil ({$validatedData['jumlah']} unit) melebihi stok yang tersedia di rak ({$barang->stock} unit).",
            ])->withInput();
        }

        // DB Transaction: Mengurangi stok sekaligus mencatat riwayat audit secara atomik
        DB::transaction(function () use ($barang, $validatedData, $request) {
            $barang->decrement('stock', $validatedData['jumlah']);

            RiwayatPengurangan::create([
                'id_barang'     => $barang->id_barang,
                'user_id'       => auth()->id(),
                'nama_mekanik'  => $validatedData['nama_mekanik'],
                'shift'         => $validatedData['shift'],
                'jumlah'        => $validatedData['jumlah'],
                'keperluan'     => $validatedData['keperluan'],
                'tanggal_ambil' => $request->filled('tanggal_ambil') ? $request->tanggal_ambil : now(),
            ]);
        });

        $sisaStok = $barang->fresh()->stock;

        return redirect()->route('pengurangan.index')
            ->with('success', "Pengambilan {$validatedData['jumlah']} unit '{$barang->nama_barang}' berhasil dicatat. Sisa stok di rak: {$sisaStok} unit.");
    }
}

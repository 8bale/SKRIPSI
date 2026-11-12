<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Model RiwayatPengurangan
 * Merepresentasikan tabel log transaksi pengurangan / pengambilan spare part.
 */
class RiwayatPengurangan extends Model
{
    protected $table = 'riwayat_pengurangan';
    protected $primaryKey = 'id_pengurangan';

    protected $fillable = [
        'id_barang',
        'user_id',
        'nama_mekanik',
        'shift',
        'jumlah',
        'keperluan',
        'tanggal_ambil',
    ];

    /**
     * Type casting atribut model.
     */
    protected function casts(): array
    {
        return [
            'tanggal_ambil' => 'datetime',
        ];
    }

    /**
     * Relasi ke barang yang diambil (Many-to-One / BelongsTo).
     */
    public function barang()
    {
        return $this->belongsTo(Barang::class, 'id_barang', 'id_barang');
    }

    /**
     * Relasi ke user / akun yang mencatat pengambilan (Many-to-One / BelongsTo).
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}

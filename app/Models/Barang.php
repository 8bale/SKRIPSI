<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Model Barang
 * Merepresentasikan tabel 'barang' untuk inventaris spare part.
 */
class Barang extends Model
{
    protected $table = 'barang';
    protected $primaryKey = 'id_barang';

    protected $fillable = [
        'nama_barang',
        'deskripsi',
        'id_rack',
        'stock',
    ];

    /**
     * Relasi ke data rak penyimpanan barang (Many-to-One / BelongsTo).
     */
    public function rack()
    {
        return $this->belongsTo(Rack::class, 'id_rack', 'id_rack');
    }

    /**
     * Relasi ke riwayat pemakaian / pengurangan barang (One-to-Many / HasMany).
     */
    public function pengurangans()
    {
        return $this->hasMany(RiwayatPengurangan::class, 'id_barang', 'id_barang');
    }
}

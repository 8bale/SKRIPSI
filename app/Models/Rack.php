<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Model Rack
 * Merepresentasikan tabel 'rack' untuk lokasi rak gudang workshop.
 */
class Rack extends Model
{
    protected $table = 'rack';
    protected $primaryKey = 'id_rack';

    protected $fillable = [
        'nama_rack',
        'lokasi',
    ];

    /**
     * Relasi ke seluruh barang yang disimpan pada rak ini (One-to-Many / HasMany).
     */
    public function barangs()
    {
        return $this->hasMany(Barang::class, 'id_rack', 'id_rack');
    }
}

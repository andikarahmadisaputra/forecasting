<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
{
    use HasFactory;

    protected $table = 'kategoris';

    protected $fillable = ['kode', 'nama', 'stok_minimal', 'stok_maksimal', 'stok_aman', 'buffer', 'stok_sekarang'];

    public function penjualan()
    {
        return $this->hasMany(Penjualan::class);
    }

    public function peramalanHeader()
    {
        return $this->hasMany(PeramalanHeader::class);
    }
}

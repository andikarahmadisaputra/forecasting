<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penjualan extends Model
{
    use HasFactory;

    protected $table = 'penjualans';

    protected $fillable = ['kategori_id', 'tanggal', 'jumlah'];

    public function kategori()
    {
        return $this->belongsTo(Kategori::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PeramalanHeader extends Model
{
    use HasFactory;

    protected $table = 'peramalan_headers';

    protected $fillable = ['tanggal' ,'kategori_id', 'hasil', 'alpha', 'beta', 'mse', 'mad', 'mape', 'rmse'];

    public function kategori()
    {
        return $this->belongsTo(Kategori::class);
    }

    public function peramalanDetail()
    {
        return $this->hasMany(PeramalanDetail::class);
    }
}

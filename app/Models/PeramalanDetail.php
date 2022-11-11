<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PeramalanDetail extends Model
{
    use HasFactory;

    protected $table = 'peramalan_details';

    protected $fillable = ['peramlan_header_id', 'tanggal' ,'aktual', 'level', 'trend', 'peramalan', 'se', 'ad', 'ape'];

    public function peramalanHeader()
    {
        return $this->belongsTo(Peramalanheader::class);
    }
}

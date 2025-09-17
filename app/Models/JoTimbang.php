<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JoTimbang extends Model
{
    protected $table = 'jo_timbang_temp';

    protected $primaryKey = "Id";
    public $timestamps = false;
    protected $fillable = [
        'Id', 'NO_JO', 'UNIQ_ID',
        'ID_BARANG', 'BERAT_TOTAL',
        'BERAT_PER_JO', 'IDX_TB',
        'FLAG', 'NIK_GANTI_JO',
        'TGL_GANTI_NO_JO'
    ];
    
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class TbTimbangVt extends Model
{
    use HasFactory, Notifiable;

    protected $table = 'tb_timbang_vt_temp';
    protected $primaryKey = "ID";
    public $timestamps = false;
    protected $fillable = [
        'ID', 'NO_DOK', 'NO_LOT',
        'ITEM_CODE', 'BERAT', 'BERAT_FILTER',
        'BATCH', 'KET', 'SERAH', 'TERIMA',
        'VERIFIKATOR', 'WAKTU_TIMBANG', 
        'WAKTU_PROD', 'SHIFT_TIMBANG',
        'SHIFT_PROD', 'PLANT', 'BERAT_PER_LOT'
    ];

}

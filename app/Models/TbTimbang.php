<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class TbTimbang extends Model
{
    use HasFactory, Notifiable;
    protected $table = 'tb_timbang_temp';
    protected $primaryKey = "ID";
    public $timestamps = false;
    protected $fillable = [
        'ID', 'ID_BARANG', 'UNIQ_ID',
        'BERAT', 'BERAT_FILTER', 'QTY',
        'WAKTU', 'NAMA_BARANG', 'KATEGORI',
        'NAMA_USER', 'DARI', 'SHIFT', 'PIC_SERAH',
        'PIC_TERIMA', 'ID_PRINT', 'SATUAN', 'PCS',
        'TGL_PRODUKSI', 'SHIFT_PRODUKSI', 'KETERANGAN',
        'WTA', 'WHT', 'WAKTU_SINKRON', 'IDX_TB', 'ASAL',
        'TUJUAN', 'PLANT'
    ];

    protected $casts = ['WAKTU' => 'datetime'];
    
}

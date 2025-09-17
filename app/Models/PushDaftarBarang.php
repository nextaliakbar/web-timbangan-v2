<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class PushDaftarBarang extends Model
{
    use HasFactory, Notifiable;

    protected $table = 'push_daftar_barang_temp';
    protected $primaryKey = "Id";
    public $timestamps = false;
    protected $fillable = [
        'Id', 'ID_BARANG', 'ID_SUNFISH',
        'NAMA_BARANG', 'itemCategoryType',
        'KATEGORI', 'SATUAN', 'MIN', 'MAX',
        'PENGURANG', 'FLAG', 'FLAG_UMS_2',
        'FLAG_MGFI', 'STATUS', 'INACTIVE'
    ];

}

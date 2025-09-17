<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TbWarehouseSf extends Model
{
    protected $table = 'tb_warehouse_sf';
    protected $primaryKey = "Id";
    public $timestamps = false;
    protected $fillable = [
        'Id',
        'WAREHOUSE_ID_SF',
        'WAREHOUSE_NAME',
        'BIN_ID',
        'Produksi Formulasi Bin1',
        'COMPANY_ID'
    ];
}

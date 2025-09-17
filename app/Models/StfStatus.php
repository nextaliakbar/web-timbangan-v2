<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StfStatus extends Model
{
    protected $table = 'stf_status_temp';
    protected $primaryKey = "ID";
    public $timestamps = false;
    protected $fillable = [
        'ID', 'NO_JO',
        'NO_STF', 'STATUS', 
        'TANGGAL', 'WTA'
    ];
}

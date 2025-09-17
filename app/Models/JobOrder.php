<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JobOrder extends Model
{
    protected $table = 'job_order_temp';
    protected $primaryKey = 'Id';
    public $timestamps = false;
    protected $fillable = [
        'Id', 'NO_JO', 'COMPANY_ID',
        'JO_DATE', 'SHIFT', 'FLAG',
        'WH_ID'
    ];
}

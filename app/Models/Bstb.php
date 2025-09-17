<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bstb extends Model
{
    protected $table = 'bstb_temp';

    protected $primaryKey = "Id";

    public $timestamps = false;

    protected $fillable = ['Id', 'DARIKE', 'NO','PLANT'];
}

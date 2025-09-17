<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mesin extends Model
{
    protected $table = 'mesin_temp';
    public $timestamps = false;
    protected $fillable = [
        'line', 'company'
    ];
}

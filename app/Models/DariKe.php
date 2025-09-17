<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class DariKe extends Model
{
    use HasFactory, Notifiable;

    protected $table = 'dari_ke_temp';

    protected $primaryKey = "Id";

    public $timestamps = false;

    public $fillable = [
        'Id', 'DARI_KE', 'KODE',
        'DARI', 'KE', 'DG_JO','PLANT'
    ];

}

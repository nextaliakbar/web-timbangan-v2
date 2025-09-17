<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class User extends Model
{
    use HasFactory, Notifiable;
    protected $table = 'user';
    protected $primaryKey = "ID";
    public $timestamps = false;
    protected $fillable = [
        'ID', 'USER', 'PASS',
        'PIC', 'TEMPAT', 'BAGIAN',
        'HAK', 'FLAG', 'FLAG_UMS_2',
        'FLAG_MGFI'
    ];
}

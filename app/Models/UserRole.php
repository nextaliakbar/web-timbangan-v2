<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class UserRole extends Model
{
    use HasFactory, Notifiable;

    protected $table = 'user_roles';

    protected $fillable = ['id', 'role', 'modules', 'status'];

    protected $casts = ['modules' => 'array', 'status' => 'boolean'];

    public function userEsa()
    {
        return $this->belongsTo(UserEsa::class, 'role', 'HAK');
    }
}

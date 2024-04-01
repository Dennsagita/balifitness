<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Coach extends Authenticatable
{
    use HasFactory;

    protected $table = "coaches";
    protected $primaryKey = "id";
    protected $fillable = [
        'nama',
        'email',
        'password',
        'alamat',
        'no_telp',
    ];



    protected $hidden = [
        'password',
        'remember_token',
    ];



    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function materis()
    {
        return $this->hasMany(Materi::class, 'id_coach', 'id');
    }
}

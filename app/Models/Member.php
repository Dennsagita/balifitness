<?php

namespace App\Models;

use App\Models\Logaktivitas;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Member extends Authenticatable
{
    use HasFactory;

    protected $table = "members";
    protected $primaryKey = "id";
    protected $fillable = [
        'nama',
        'email',
        'password',
        'alamat',
        'no_telp',
    ];
    public function logaktivitas()
    {
        return $this->hasMany(Logaktivitas::class, 'id_members', 'id');
    }


    protected $hidden = [
        'password',
        'remember_token',
    ];



    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];
}

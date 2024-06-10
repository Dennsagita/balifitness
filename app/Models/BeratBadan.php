<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BeratBadan extends Model
{
    use HasFactory;
    protected $table = "berat_badan";
    protected $primaryKey = "id";
    protected $fillable = [
        'id_member',
        'berat_badan'
    ];

    public function member()
    {
        return $this->belongsTo(Member::class, 'id_member');
    }

    public function logAktivitas()
    {
        return $this->hasMany(LogAktivitas::class, 'id_berat_badan');
    }
}

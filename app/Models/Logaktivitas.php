<?php

namespace App\Models;

use App\Models\BeratBadan;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Logaktivitas extends Model
{
    use HasFactory;
    protected $table = "log_aktivitas";
    protected $primaryKey = "id";
    protected $fillable = [
        'id_members',
        'id_materi',
        'deskripsi',
    ];

    public function member()
    {
        return $this->belongsTo(Member::class, 'id_members');
    }

    public function materi()
    {
        return $this->belongsTo(Materi::class, 'id_materi');
    }
}

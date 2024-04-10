<?php

namespace App\Models;

use App\Models\Coach;
use App\Models\Kategori;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Materi extends Model
{
    use HasFactory;

    protected $table = "materis";
    protected $primaryKey = "id";
    protected $fillable = [
        'id_kategori',
        'id_coach',
        'nama',
        'deskripsi',
        'link_video',
    ];

    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'id_kategori');
    }

    public function coach()
    {
        return $this->belongsTo(Coach::class, 'id_coach');
    }

    public function logaktivitas()
    {
        return $this->hasMany(Logaktivitas::class, 'id_coach', 'id');
    }
}

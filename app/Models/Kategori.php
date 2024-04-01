<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
{
    use HasFactory;

    protected $table = "kategoris";
    protected $primaryKey = "id";
    protected $fillable = [
        'nama',
    ];

    public function materis()
    {
        return $this->hasMany(Materi::class, 'id_kategori', 'id');
    }
}

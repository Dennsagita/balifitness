<?php

namespace App\Models;

use App\Models\Coach;
use App\Models\Image;
use App\Models\Kategori;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
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

    //relation
    public function images()
    {
        return $this->morphOne(Image::class, 'imageable');
    }
    // boot
    public static function boot()
    {
        parent::boot();

        self::creating(function ($materi) {
            $materi->id = request()->id;
        });

        self::created(function ($materi) {
            foreach (request()->file('images') ?? [] as $key => $image) {
                $uploaded = Image::uploadImage($image);
                Image::create([
                    'thumb' => 'thumbnails/' . basename($uploaded['thumb']),
                    'src' => 'images/' . basename($uploaded['src']),
                    'alt' => Image::getAlt($image),
                    'imageable_id' => $materi->id,
                    'imageable_type' => "App\Models\Materi"
                ]);
            }
        });

        self::updating(function ($materi) {
            $img_array = explode(',', request()->deleted_images);
            array_pop($img_array);

            // Hapus gambar yang dihapus dari penyimpanan lokal
            foreach ($img_array as $key => $image_id) {
                $will_deleted_image = Image::find($image_id);
                if (!is_null($will_deleted_image)) {
                    Storage::delete([$will_deleted_image->src, $will_deleted_image->thumb]);
                    $will_deleted_image->delete();
                }
            }

            // Unggah dan simpan gambar baru secara lokal
            foreach (request()->file('images') ?? [] as $key => $image) {
                $uploaded = Image::uploadImage($image);
                Image::create([
                    'thumb' => 'thumbnails/' . basename($uploaded['thumb']),
                    'src' => 'images/' . basename($uploaded['src']),
                    'alt' => Image::getAlt($image),
                    'imageable_id' => $materi->id,
                    'imageable_type' => "App\Models\materi"
                ]);
            }
        });


        self::updated(function ($image) {
            if (!is_null($image->src)) {
                Storage::delete($image->src);
            }
            if (!is_null($image->thumb)) {
                Storage::delete($image->thumb);
            }
        });

        static::deleting(function ($materi) {
            $materi->images()->delete();
        });

        self::deleted(function ($materi) {
        });
    }
}

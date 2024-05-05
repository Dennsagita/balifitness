<?php

namespace App\Models;

use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Notifications\Notifiable;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Coach extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, CanResetPassword;

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

    //relation
    public function images()
    {
        return $this->morphOne(Image::class, 'imageable');
    }
    // boot
    public static function boot()
    {
        parent::boot();

        self::creating(function ($coach) {
            $coach->id = request()->id;
        });

        self::created(function ($coach) {
            foreach (request()->file('images') ?? [] as $key => $image) {
                $uploaded = Image::uploadImage($image);
                Image::create([
                    'thumb' => 'thumbnails/' . basename($uploaded['thumb']),
                    'src' => 'images/' . basename($uploaded['src']),
                    'alt' => Image::getAlt($image),
                    'imageable_id' => $coach->id,
                    'imageable_type' => "App\Models\coach"
                ]);
            }
        });

        self::updating(function ($coach) {
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
                    'imageable_id' => $coach->id,
                    'imageable_type' => "App\Models\coach"
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

        static::deleting(function ($coach) {
            $coach->images()->delete();
        });

        self::deleted(function ($coach) {
        });
    }
}

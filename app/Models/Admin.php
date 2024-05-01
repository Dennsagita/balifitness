<?php

namespace App\Models;

use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Notifications\Notifiable;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Admin extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, CanResetPassword;

    protected $table = "admins";
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

    //relation
    public function images()
    {
        return $this->morphOne(Image::class, 'imageable');
    }
    // boot
    public static function boot()
    {
        parent::boot();

        self::creating(function ($admin) {
            $admin->id = request()->id;
        });

        self::created(function ($admin) {
            foreach (request()->file('images') ?? [] as $key => $image) {
                $uploaded = Image::uploadImage($image);
                Image::create([
                    'thumb' => 'thumbnails/' . basename($uploaded['thumb']),
                    'src' => 'images/' . basename($uploaded['src']),
                    'alt' => Image::getAlt($image),
                    'imageable_id' => $admin->id,
                    'imageable_type' => "App\Models\Admin"
                ]);
            }
        });

        self::updating(function ($admin) {
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
                    'imageable_id' => $admin->id,
                    'imageable_type' => "App\Models\Admin"
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

        static::deleting(function ($admin) {
            $admin->images()->delete();
        });

        self::deleted(function ($admin) {
        });
    }
}

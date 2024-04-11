<?php

namespace App\Models;

use App\Models\Logaktivitas;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
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

    //relation
    public function images()
    {
        return $this->morphOne(Image::class, 'imageable');
    }
    // boot
    public static function boot()
    {
        parent::boot();

        self::creating(function ($member) {
            $member->id = request()->id;
        });

        self::created(function ($member) {
            foreach (request()->file('images') ?? [] as $key => $image) {
                $uploaded = Image::uploadImage($image);
                Image::create([
                    'thumb' => 'thumbnails/' . basename($uploaded['thumb']),
                    'src' => 'images/' . basename($uploaded['src']),
                    'alt' => Image::getAlt($image),
                    'imageable_id' => $member->id,
                    'imageable_type' => "App\Models\Member"
                ]);
            }
        });

        self::updating(function ($member) {
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
                    'imageable_id' => $member->id,
                    'imageable_type' => "App\Models\Member"
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

        static::deleting(function ($member) {
            $member->images()->delete();
        });

        self::deleted(function ($member) {
        });
    }
}

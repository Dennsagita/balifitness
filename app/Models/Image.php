<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image as InterventionImg;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    use HasFactory;
    protected $table = 'images';
    protected $fillable = ['src', 'thumb', 'alt', 'imageable_id', 'imageable_type'];

    public function imageable()
    {
        return $this->morphTo();
    }

    public static function uploadImage($img_response, $rezize = true)
    {
        // Simpan gambar secara lokal
        $imagePaths = [];

        if ($rezize == true) {
            $thumbnailPath = storage_path('app/public/thumbnails/' . $img_response->hashName());
            $imagePath = storage_path('app/public/images/' . $img_response->hashName());

            InterventionImg::make($img_response->getPathname())
                ->resize(390, 220, function ($constraint) {
                    $constraint->aspectRatio();
                })->save($thumbnailPath, 60);

            InterventionImg::make($img_response->getPathname())
                ->resize(800, 550, function ($constraint) {
                    $constraint->aspectRatio();
                })->save($imagePath, 90);

            $imagePaths = [
                'thumb' => $thumbnailPath,
                'src' => $imagePath
            ];
        }

        return $imagePaths;
    }

    public static function getImage()
    {
        $file_name = Str::random(10) . '.jpg';
        $raw_image = InterventionImg::make('https://picsum.photos/1300/600?random=' . mt_rand(1, 6));
        $thumbnail = $raw_image->resize(290, 220, function ($constraint) {
            $constraint->aspectratio();
        })->save(storage_path('app/public/thumbnails/' . $file_name), 60, 'jpg');

        $image = $raw_image->resize(800, 550, function ($constraint) {
            $constraint->aspectratio();
        })->save(storage_path('app/public/images/' . $file_name), 60, 'jpg');

        return [
            'thumb' => $thumbnail,
            'src' => $image
        ];
    }

    public static function getAlt($image)
    {
        return trim(str_replace(['.jpeg', '.jpg', '.png'], '', $image->getClientOriginalName()), ' \.');
    }

    // boot
    public static function boot()
    {
        parent::boot();

        self::creating(function ($image) {
            // ... code here
        });

        self::created(function ($image) {
            // ... code here
        });

        self::updating(function ($image) {
            // ... code here
        });

        self::updated(function ($image) {
            // ... code here
        });

        self::deleted(function ($image) {
            Storage::delete([$image->src, $image->thumb]);
        });

        self::deleting(function ($image) {
            // Pastikan $image adalah instance dari model Image
            if ($image instanceof Image) {
                // Hapus file gambar dari penyimpanan
                Storage::delete([$image->src, $image->thumb]);
            }
        });
    }
}

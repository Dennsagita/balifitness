<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    public function profiladmin()
    {
        // Mengambil data admin yang sedang login
        $admin = Auth::guard('admin')->user();
        return view('post-dashboard.profil-admin', compact('admin'));
    }

    public function updateadmin(Request $request)
    {
        $admin = Admin::find(Auth::id());
        $admin->update($request->all());
        // Cek apakah ada gambar yang diunggah dalam request
        if ($request->hasFile('image')) {
            // Hapus gambar-gambar yang terkait dengan Dbsarana ini
            if ($admin->images instanceof Image) {
                // Hapus gambar dari penyimpanan
                Storage::delete($admin->images->src);
                // Hapus record gambar dari database
                $admin->images->delete();
            }



            // Upload dan simpan gambar baru
            $imagePath = $request->file('image')->store('images', 'public');
            $image = Image::create([
                'path' => $imagePath,
                'src' => $imagePath, // Sesuaikan nilai 'src' sesuai dengan 'path'
                'thumb' => $imagePath,
                'alt' => $imagePath,
                'imageable_id' => $admin->id, // Berikan nilai 'imageable_id'
                'imageable_type' => 'App\Models\admin', // Sesuaikan dengan tipe model yang berelasi
            ]);
            // Asosiasikan gambar dengan entitas menggunakan relasi polimorfik
            $admin->images()->save($image);
        }
        // Redirect kembali ke halaman dengan pesan sukses
        return redirect()->route('profiladmin')->with('editadmin', 'Data profil berhasil diubah.');
    }
}

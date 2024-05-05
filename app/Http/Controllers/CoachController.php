<?php

namespace App\Http\Controllers;

use App\Models\Coach;
use App\Models\Image;
use App\Models\Logaktivitas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class CoachController extends Controller
{
    public function index()
    {
        // Mengambil data admin yang sedang login
        $admin = Auth::guard('admin')->user();
        $coaches = Coach::all();
        return view('post-dashboard.coach.coach', compact('coaches', 'admin'));
    }

    public function create()
    {
        // Mengambil data admin yang sedang login
        $admin = Auth::guard('admin')->user();
        // Mendapatkan nomor urut berikutnya
        return view('post-dashboard.coach.tambah_coach', compact('admin'));
    }

    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'nama' => 'required',
            'email' => 'required|email',
            'password' => 'required', // Validasi untuk password
            'no_telp' => 'required',
            'alamat' => 'required',
        ]);

        // Simpan data
        Coach::create([
            'nama' => $request->nama,
            'email' => $request->email,
            'password' => Hash::make($request->password), // Hash password sebelum disimpan
            'no_telp' => $request->no_telp,
            'alamat' => $request->alamat,
        ]);

        return redirect()->route('datacoach')->with('success', 'Data coach berhasil disimpan.');
    }

    //hapus coach
    public function delete($id)
    {
        $delete =  Coach::find($id);

        if (!$delete) {
            return abort(404, 'delete not found');
        }

        $delete->delete();

        return redirect()->route('datacoach')->with('delete', 'Data coach berhasil dihapus');
    }


    // Halaman Dashboard Untuk Akun Coach
    public function coach()
    {
        // Mendapatkan Data coach yang sedang login
        $coach = Auth::guard('coach')->user();
        // Mendapatkan ID coach yang sedang login
        $coachId = Auth::guard('coach')->user()->id;

        // Mengambil data log aktivitas berdasarkan ID coach yang sedang login
        $logaktivitas = Logaktivitas::whereHas('materi', function ($query) use ($coachId) {
            $query->where('id_coach', $coachId);
        })->get();

        // Mengirim data log aktivitas ke view
        return view('post-dashboard.coach-dashboard.materi-coach', compact('logaktivitas', 'coach'));
    }

    public function profilcoach()
    {
        // Mengambil data coach yang sedang login
        $coach = Auth::guard('coach')->user();
        return view('post-dashboard.coach-dashboard.profilcoach', compact('coach'));
    }

    public function updatecoach(Request $request)
    {
        $coach = Coach::find(Auth::id());
        $coach->update($request->all());
        // Cek apakah ada gambar yang diunggah dalam request
        if ($request->hasFile('image')) {
            // Hapus gambar-gambar yang terkait dengan Dbsarana ini
            if ($coach->images instanceof Image) {
                // Hapus gambar dari penyimpanan
                Storage::delete($coach->images->src);
                // Hapus record gambar dari database
                $coach->images->delete();
            }



            // Upload dan simpan gambar baru
            $imagePath = $request->file('image')->store('images', 'public');
            $image = Image::create([
                'path' => $imagePath,
                'src' => $imagePath, // Sesuaikan nilai 'src' sesuai dengan 'path'
                'thumb' => $imagePath,
                'alt' => $imagePath,
                'imageable_id' => $coach->id, // Berikan nilai 'imageable_id'
                'imageable_type' => 'App\Models\Coach', // Sesuaikan dengan tipe model yang berelasi
            ]);
            // Asosiasikan gambar dengan entitas menggunakan relasi polimorfik
            $coach->images()->save($image);
        }
        // Redirect kembali ke halaman dengan pesan sukses
        return redirect()->route('profilcoach')->with('editcoach', 'Profil berhasil diubah.');
    }
}

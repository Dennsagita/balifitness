<?php

namespace App\Http\Controllers;

use App\Models\Coach;
use App\Models\Image;
use App\Models\Materi;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MateriController extends Controller
{
    public function materi()
    {
        //mengambil data dari tabel kategori
        $kategori = Kategori::all();
        // Mengambil semua data materi dari database beserta relasi Kategori dan Coach
        $materi = Materi::with('kategori', 'coach')->get();

        return view('post-dashboard.materi.materi', compact('materi', 'kategori'));
    }

    public function lihat($id)
    {
        // Mengambil data materi berdasarkan ID
        $materi = Materi::findOrFail($id);

        // Mengirim data materi ke view 'materi.show' untuk ditampilkan
        return view('post-dashboard.materi.lihat_materi', compact('materi'));
    }

    public function create()
    {
        // Mendapatkan nomor urut berikutnya
        $kategori = Kategori::all();
        $coach = Coach::all();
        return view('post-dashboard.materi.tambah_materi', compact('kategori', 'coach'));
    }

    //tambah data
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'id_kategori' => 'required',
            'id_coach' => 'required',
            'nama' => 'required',
            'deskripsi' => 'required', // Validasi untuk password
            'link_video' => 'required',
        ]);

        // Simpan data
        Materi::create([
            'id_kategori' => $request->id_kategori,
            'id_coach' => $request->id_coach,
            'nama' => $request->nama,
            'deskripsi' => $request->deskripsi, // Hash password sebelum disimpan
            'link_video' => $request->link_video,
        ]);

        return redirect()->route('datamateri')->with('success', 'Data materi berhasil disimpan.');
    }

    public function editmateri($id)
    {
        // Temukan materi berdasarkan ID
        $materi = Materi::find($id);
        $kategori = Kategori::all();
        $coach = Coach::all();
        // Jika materi tidak ditemukan, kembalikan respons dengan pesan error
        if (!$materi) {
            return redirect()->back()->with('error', 'materi tidak ditemukan.');
        }

        // Tampilkan view form edit materi dengan data materi yang ditemukan
        return view('post-dashboard.materi.ubah_materi', compact('materi', 'kategori', 'coach'));
    }

    public function updatemateri(Request $request, $id)
    {
        // Validasi input
        $request->validate([
            'id_kategori' => 'required',
            'id_coach' => 'required',
            'nama' => 'required',
            'deskripsi' => 'required',
            'link_video' => 'required',
        ], [
            'id_kategori.required' => 'kategori harus diisi.',
            'id_coach.required' => 'coach harus diisi.',
            'nama.required' => 'nama harus diisi.',
            'deskripsi.required' => 'deskripsi harus diisi.',
            'link_video.required' => 'link_video harus diisi.',
        ]);

        // Cari materi berdasarkan ID
        $materi = Materi::find($id);

        // Jika materi tidak ditemukan, kembalikan respons dengan pesan error
        if (!$materi) {
            return redirect()->back()->with('error', 'materi tidak ditemukan.');
        }

        // Update data materi
        $materi->id_kategori = $request->id_kategori;
        $materi->id_coach = $request->id_coach;
        $materi->nama = $request->nama;
        $materi->deskripsi = $request->deskripsi;
        $materi->link_video = $request->link_video;
        $materi->save();

        // Cek apakah ada gambar yang diunggah dalam request
        if ($request->hasFile('image')) {
            // Hapus gambar-gambar yang terkait dengan Dbsarana ini
            if ($materi->images instanceof Image) {
                // Hapus gambar dari penyimpanan
                Storage::delete($materi->images->src);
                // Hapus record gambar dari database
                $materi->images->delete();
            }



            // Upload dan simpan gambar baru
            $imagePath = $request->file('image')->store('images', 'public');
            $image = Image::create([
                'path' => $imagePath,
                'src' => $imagePath, // Sesuaikan nilai 'src' sesuai dengan 'path'
                'thumb' => $imagePath,
                'alt' => $imagePath,
                'imageable_id' => $materi->id, // Berikan nilai 'imageable_id'
                'imageable_type' => 'App\Models\Materi', // Sesuaikan dengan tipe model yang berelasi
            ]);
            // Asosiasikan gambar dengan entitas menggunakan relasi polimorfik
            $materi->images()->save($image);
        }
        // Redirect kembali ke halaman dengan pesan sukses
        return redirect()->route('datamateri')->with('editmateri', 'Materi berhasil diubah.');
    }

    public function deletemateri($id)
    {
        // Temukan materi berdasarkan ID
        $materi = Materi::find($id);

        // Jika materi tidak ditemukan, kembalikan respons dengan pesan error
        if (!$materi) {
            return redirect()->back()->with('error', 'materi tidak ditemukan.');
        }

        // Hapus materi
        $materi->delete();

        // Redirect kembali ke halaman dengan pesan sukses
        return redirect()->route('datamateri')->with('deletemateri', 'Kategori berhasil dihapus.');
    }

    public function tambahkategori()
    {
        return view('post-dashboard.materi.kategori.tambah_kategori');
    }

    //tambah data Kategori
    public function insertkategori(Request $request)
    {
        // Validasi input
        $request->validate([
            'nama' => 'required',
        ], [
            'nama.required' => 'Kolom nama harus diisi.',
        ]);

        // Simpan data
        Kategori::create([
            'nama' => $request->nama,
        ]);

        return redirect()->route('datamateri')->with('kategori', 'Data Kategori berhasil ditambahkan.');
    }

    public function editkategori($id)
    {
        // Temukan kategori berdasarkan ID
        $kategori = Kategori::find($id);

        // Jika kategori tidak ditemukan, kembalikan respons dengan pesan error
        if (!$kategori) {
            return redirect()->back()->with('error', 'Kategori tidak ditemukan.');
        }

        // Tampilkan view form edit kategori dengan data kategori yang ditemukan
        return view('post-dashboard.materi.kategori.ubah_kategori', compact('kategori'));
    }

    public function updatekategori(Request $request, $id)
    {
        // Validasi data input
        $request->validate([
            'nama' => 'required|string|max:255',
        ]);

        // Cari kategori berdasarkan ID
        $kategori = Kategori::find($id);

        // Jika kategori tidak ditemukan, kembalikan respons dengan pesan error
        if (!$kategori) {
            return redirect()->back()->with('error', 'Kategori tidak ditemukan.');
        }

        // Update data kategori
        $kategori->nama = $request->nama;
        $kategori->save();

        // Redirect kembali ke halaman dengan pesan sukses
        return redirect()->route('datamateri')->with('editkategori', 'Kategori berhasil diubah.');
    }

    public function deletekategori($id)
    {
        // Temukan kategori berdasarkan ID
        $kategori = Kategori::find($id);

        // Jika kategori tidak ditemukan, kembalikan respons dengan pesan error
        if (!$kategori) {
            return redirect()->back()->with('error', 'Kategori tidak ditemukan.');
        }

        // Hapus kategori
        $kategori->delete();

        // Redirect kembali ke halaman dengan pesan sukses
        return redirect()->route('datamateri')->with('deletekategori', 'Kategori berhasil dihapus.');
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use App\Models\Materi;
use Illuminate\Http\Request;

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
}

<?php

namespace App\Http\Controllers;

use App\Models\Materi;
use App\Models\Kategori;
use Illuminate\Http\Request;

class LandingpageController extends Controller
{
    public function index()
    {
        $kategori = Kategori::all();
        // Mengambil semua data materi dari database beserta relasi Kategori dan Coach
        $materi = Materi::with('kategori', 'coach')->get();
        return view('post-landingpage.beranda', compact('materi', 'kategori'));
    }

    public function detailkategori()
    {
        $kategori = Kategori::all();
        // Mengambil semua data materi dari database beserta relasi Kategori dan Coach
        $materi = Materi::with('kategori', 'coach')->get();
        return view('post-landingpage.detail-kategori', compact('materi', 'kategori'));
    }
}

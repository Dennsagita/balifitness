<?php

namespace App\Http\Controllers;

use App\Models\Coach;
use App\Models\Materi;
use App\Models\Kategori;
use App\Mail\KontakEmail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class LandingpageController extends Controller
{
    public function index()
    {
        $kategori = Kategori::all();
        // Mengambil semua data materi dari database beserta relasi Kategori dan Coach
        $materi = Materi::with('kategori', 'coach')->get();
        return view('post-landingpage.beranda', compact('materi', 'kategori'));
    }

    public function tentangkami()
    {
        $coach = Coach::all();
        return view('post-landingpage.tentangkami', compact('coach'));
    }

    public function kategoritraining(Request $request)
    {
        $kategori = Kategori::all();

        // Mendapatkan data kategori yang dipilih dari dropdown
        $selected_kategori = $request->input('kategori');

        // Mendapatkan kata kunci pencarian
        $keyword = $request->input('keyword');

        // Query awal untuk mendapatkan semua materi dengan relasi Kategori dan Coach
        $query = Materi::with('kategori', 'coach');

        // Filter berdasarkan kategori jika dipilih
        if ($selected_kategori && $selected_kategori != 'all') {
            $query->where('id_kategori', $selected_kategori);
        }

        // Filter berdasarkan keyword pencarian
        if ($keyword) {
            $query->where(function ($q) use ($keyword) {
                $q->where('nama', 'like', '%' . $keyword . '%')
                    ->orWhereHas('kategori', function ($q) use ($keyword) {
                        $q->where('nama', 'like', '%' . $keyword . '%');
                    });
            });
        }

        // Mendapatkan hasil query
        $materi = $query->get();

        return view('post-landingpage.kategoritraining', compact('materi', 'kategori'));
    }


    public function detailkategori($id)
    {
        //mengambil data dari tabel kategori
        $kategori = Kategori::all();
        // Mengambil semua data materi dari database beserta relasi Kategori dan Coach
        $materi = Materi::with('kategori', 'coach')->findOrFail($id);
        return view('post-landingpage.detail-kategori', compact('materi', 'kategori'));
    }

    public function kontak()
    {
        return view('post-landingpage.kontak');
    }

    public function kirimEmail(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'subject' => 'required',
            'message' => 'required',
        ], [
            'name.required' => 'Nama harus diisi',
            'email.required' => 'Alamat email harus diisi',
            'email.email' => 'Alamat email tidak valid',
            'subject.required' => 'Subjek harus diisi',
            'message.required' => 'Pesan harus diisi',
        ]);

        // Kirim email
        Mail::to('balifitnessseminyak042@gmail.com')->send(new KontakEmail($validatedData));

        return back()->with('success', 'Pesan Anda telah berhasil dikirim!');
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Coach;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class CoachController extends Controller
{
    public function index()
    {
        $coaches = Coach::all();
        return view('post-dashboard.coach.coach', compact('coaches'));
    }

    public function create()
    {
        // Mendapatkan nomor urut berikutnya
        return view('post-dashboard.coach.tambah_coach');
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

    //hapus member
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
        return view('post-dashboard.coach-dashboard.materi-coach');
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Materi;
use App\Models\Member;
use App\Models\Kategori;
use App\Models\Logaktivitas;
use Illuminate\Http\Request;

class MemberController extends Controller
{
    public function index()
    {
        $member = Member::all();
        return view('post-dashboard.member.member', compact('member'));
    }

    //hapus member
    public function delete($id)
    {
        $delete =  Member::find($id);

        if (!$delete) {
            return abort(404, 'delete not found');
        }

        $delete->delete();

        return redirect()->route('datamember')->with('delete', 'Data member berhasil dihapus');
    }

    // Halaman Dashboard Untuk Akun Member
    public function member()
    {
        //mengambil data dari tabel kategori
        $kategori = Kategori::all();
        // Mengambil semua data materi dari database beserta relasi Kategori dan Coach
        $materi = Materi::with('kategori', 'coach')->get();
        return view('post-dashboard.member-dashboard.materi-member', compact('materi', 'kategori'));
    }

    public function pilihmateri($id)
    {
        //mengambil data dari tabel kategori
        $kategori = Kategori::all();
        // Mengambil semua data materi dari database beserta relasi Kategori dan Coach
        $materi = Materi::with('kategori', 'coach')->findOrFail($id);
        return view('post-dashboard.member-dashboard.pilih_materi', compact('materi', 'kategori'));
    }

    public function prosespilihmateri(Request $request)
    {
        // Validasi input
        $request->validate([
            'id_members' => 'required',
            'id_materi' => 'required',
            'deskripsi' => 'required', // Validasi untuk password
        ], [
            'id_members.required' => 'Member harus diisi.',
            'id_materi.required' => 'Materi harus diisi.',
            'deskripsi.required' => 'deskripsi harus diisi.',
        ]);

        // Simpan data
        Logaktivitas::create([
            'id_members' => $request->id_members,
            'id_materi' => $request->id_materi,
            'deskripsi' => $request->deskripsi, // Hash password sebelum disimpan
        ]);

        return redirect()->route('materi-member')->with('success', 'Materi berhasil disimpan.');
    }
}

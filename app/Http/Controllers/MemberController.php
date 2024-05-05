<?php

namespace App\Http\Controllers;

use App\Models\Image;
use App\Models\Materi;
use App\Models\Member;
use App\Models\Kategori;
use App\Models\Logaktivitas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class MemberController extends Controller
{
    public function index()
    {
        // Mengambil data admin yang sedang login
        $admin = Auth::guard('admin')->user();
        $member = Member::all();
        return view('post-dashboard.member.member', compact('member', 'admin'));
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
    public function member(Request $request)
    {
        $member = Auth::guard('member')->user();
        $kategori = Kategori::all();

        $query = Materi::with('kategori', 'coach');

        // Filter berdasarkan kategori jika dipilih
        $selected_kategori = $request->input('kategori');
        if ($selected_kategori && $selected_kategori != 'all') {
            $query->whereHas('kategori', function ($q) use ($selected_kategori) {
                $q->where('id', $selected_kategori);
            });
        }

        // Filter berdasarkan kata kunci pencarian
        $keyword = $request->input('keyword');
        if ($keyword) {
            $query->where(function ($q) use ($keyword) {
                $q->where('nama', 'like', '%' . $keyword . '%')
                    ->orWhereHas('kategori', function ($q) use ($keyword) {
                        $q->where('nama', 'like', '%' . $keyword . '%');
                    });
            });
        }

        $materi = $query->get();

        return view('post-dashboard.member-dashboard.materi-member', compact('materi', 'kategori', 'member'));
    }


    public function pilihmateri($id)
    {
        // Mengambil data member yang sedang login
        $member = Auth::guard('member')->user();
        //mengambil data dari tabel kategori
        $kategori = Kategori::all();
        // Mengambil semua data materi dari database beserta relasi Kategori dan Coach
        $materi = Materi::with('kategori', 'coach')->findOrFail($id);
        return view('post-dashboard.member-dashboard.pilih_materi', compact('materi', 'kategori', 'member'));
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

        // Periksa apakah materi sudah dipilih sebelumnya oleh member
        $existingLog = Logaktivitas::where('id_members', $request->id_members)
            ->where('id_materi', $request->id_materi)
            ->exists();

        // Jika materi sudah dipilih sebelumnya, tampilkan pesan kesalahan
        if ($existingLog) {
            return redirect()->back()->with('error', 'Anda sudah memilih materi ini sebelumnya.');
        }

        // Simpan data
        Logaktivitas::create([
            'id_members' => $request->id_members,
            'id_materi' => $request->id_materi,
            'deskripsi' => $request->deskripsi, // Hash password sebelum disimpan
        ]);

        return redirect()->route('materi-member')->with('success', 'Materi berhasil disimpan.');
    }

    public function logaktivitasmember()
    {
        // Mengambil data member yang sedang login
        $member = Auth::guard('member')->user();
        // Mendapatkan ID anggota yang sedang login
        $memberId = Auth::guard('member')->user()->id;

        // Mengambil log aktivitas yang terkait dengan ID anggota yang sedang login
        $logaktivitas = Logaktivitas::where('id_members', $memberId)->get();

        // Mengirimkan data log aktivitas ke view
        return view('post-dashboard.member-dashboard.log_aktivitas', compact('logaktivitas', 'member'));
    }

    public function lihatmaterimember($logaktivitasid)
    {
        // Mengambil data member yang sedang login
        $member = Auth::guard('member')->user();
        // Mengambil log aktivitas berdasarkan ID
        $logaktivitas = Logaktivitas::findOrFail($logaktivitasid);

        // Mengambil informasi materi berdasarkan ID materi dari log aktivitas
        $materi = Materi::findOrFail($logaktivitas->id_materi);

        // Mengirimkan data materi ke view
        return view('post-dashboard.member-dashboard.lihat_materi', compact('materi', 'member'));
    }

    public function profilmember()
    {
        // Mengambil data member yang sedang login
        $member = Auth::guard('member')->user();
        return view('post-dashboard.member-dashboard.profil', compact('member'));
    }

    public function updatemember(Request $request)
    {
        $member = Member::find(Auth::id());
        $member->update($request->all());
        // Cek apakah ada gambar yang diunggah dalam request
        if ($request->hasFile('image')) {
            // Hapus gambar-gambar yang terkait dengan Dbsarana ini
            if ($member->images instanceof Image) {
                // Hapus gambar dari penyimpanan
                Storage::delete($member->images->src);
                // Hapus record gambar dari database
                $member->images->delete();
            }



            // Upload dan simpan gambar baru
            $imagePath = $request->file('image')->store('images', 'public');
            $image = Image::create([
                'path' => $imagePath,
                'src' => $imagePath, // Sesuaikan nilai 'src' sesuai dengan 'path'
                'thumb' => $imagePath,
                'alt' => $imagePath,
                'imageable_id' => $member->id, // Berikan nilai 'imageable_id'
                'imageable_type' => 'App\Models\Member', // Sesuaikan dengan tipe model yang berelasi
            ]);
            // Asosiasikan gambar dengan entitas menggunakan relasi polimorfik
            $member->images()->save($image);
        }
        // Redirect kembali ke halaman dengan pesan sukses
        return redirect()->route('datamember')->with('editmember', 'member berhasil diubah.');
        return redirect()->route('profiluser');
    }
}

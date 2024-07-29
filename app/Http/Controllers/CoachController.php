<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Coach;
use App\Models\Image;
use App\Models\Materi;
use App\Models\Member;
use App\Models\Logaktivitas;
use Illuminate\Http\Request;
use App\Mail\SendEmailLaporan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
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
        // Mengambil data materi yang berelasi dengan coach yang sedang login
        $materi = Coach::find($coachId)->materis;
        // Menghitung jumlah log aktivitas per materi untuk coach yang sedang login
        $logaktivitas1 = Logaktivitas::with('materi')
            ->whereHas('materi', function ($query) use ($coachId) {
                $query->where('id_coach', $coachId);
            })
            ->select('id_materi', DB::raw('count(*) as total'))
            ->groupBy('id_materi')
            ->get();

        // Menghubungkan data materi dengan total log aktivitas
        $logAktivitasData = $materi->map(function ($materi) use ($logaktivitas1) {
            $log = $logaktivitas1->firstWhere('id_materi', $materi->id);
            return [
                'nama' => $materi->nama,
                'total' => $log ? $log->total : 0
            ];
        });
        // Mengirim data log aktivitas ke view
        return view('post-dashboard.coach-dashboard.materi-coach', compact('logaktivitas', 'coach', 'materi', 'logAktivitasData'));
    }
    public function lihatlogaktivitascoach($logaktivitasid)
    {
        // Mendapatkan Data coach yang sedang login
        $coach = Auth::guard('coach')->user();

        // Mengambil log aktivitas berdasarkan ID
        $logaktivitas = Logaktivitas::findOrFail($logaktivitasid);

        // Mengambil informasi materi berdasarkan ID materi dari log aktivitas
        $materi = Materi::findOrFail($logaktivitas->id_materi);

        // Mengambil semua entri monitoring yang terkait dengan log aktivitas ini
        $monitorings = $logaktivitas->monitoring;

        // Mengirimkan data ke view
        return view('post-dashboard.coach-dashboard.detail', compact('materi', 'coach', 'monitorings', 'logaktivitas'));
    }
    public function cetakmatericoach($tahun, $bulan, $materi)
    {
        // Konversi tahun dan bulan menjadi format Carbon
        $tanggal = Carbon::create($tahun, $bulan, 1);

        // Mengambil ID coach yang sedang login
        $coachId = Auth::guard('coach')->user()->id;
        // Mengambil ID coach yang sedang login
        $coach = Auth::guard('coach')->user();

        // Mendapatkan data log aktivitas berdasarkan ID materi, tahun, bulan, dan ID coach
        $logaktivitas = Logaktivitas::with(['member', 'materi'])
            ->whereHas('materi', function ($query) use ($materi, $coachId) {
                $query->where('id', $materi) // Sesuaikan dengan parameter materi dari form filter
                    ->where('id_coach', $coachId); // Filter berdasarkan ID coach yang sedang login
            })
            ->whereYear('created_at', $tanggal->year)
            ->whereMonth('created_at', $tanggal->month)
            ->get();

        // Menghitung nomor urut pada halaman saat ini
        $currentPage = request()->get('page', 1);
        $itemsPerPage = 5;
        $startNumber = ($currentPage - 1) * $itemsPerPage + 1;

        return view('post-dashboard.coach-dashboard.laporan', compact('logaktivitas', 'tanggal', 'startNumber', 'coach'));
    }

    public function InformasiExercise(Request $request, $id)
    {
        $logaktivitas = Logaktivitas::findOrFail($id);

        $data = [
            'id_member' => $logaktivitas->member->id,
            'nama' => $logaktivitas->member->nama,
            'tanggal' => $logaktivitas->member->created_at,
            'coach' => $logaktivitas->materi->coach->nama,
            'informasi' => $request->informasi, // Terima alasan pembatalan dari form
        ];

        Mail::to($request->recipient_email) // Menggunakan alamat email penerima dari input form
            ->send(new SendEmailLaporan($data));
        return redirect()->route('materi-coach')->with('informasi', 'Pesan berhasil dikirim');
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

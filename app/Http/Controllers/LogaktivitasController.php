<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Materi;
use App\Models\Logaktivitas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class LogaktivitasController extends Controller
{
    public function logaktivitas(Request $request)
    {
        // Mengambil data admin yang sedang login
        $admin = Auth::guard('admin')->user();
        // Mengambil semua data materi dari database beserta relasi Kategori dan Coach
        $logaktivitas = Logaktivitas::with('member', 'materi')->get();
        $materi = Materi::all(); // Mengambil semua data materi

        // Mengambil data log aktivitas berdasarkan materi
        $logaktivitas1 = Logaktivitas::with('materi')
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
        return view('post-dashboard.log_aktivitas.log_aktivitas', compact('logaktivitas', 'admin', 'materi', 'logAktivitasData'));
    }

    public function lihatcetakmateri($tahun, $bulan, $materi)
    {
        // Konversi tahun dan bulan menjadi format Carbon
        $tanggal = Carbon::create($tahun, $bulan, 1);

        $materi = Logaktivitas::with(['member', 'materi'])
            ->where('id_materi', $materi) // Sesuaikan dengan parameter materi dari form filter
            ->whereYear('created_at', $tanggal->year)
            ->whereMonth('created_at', $tanggal->month)
            ->get();

        // Menghitung nomor urut pada halaman saat ini
        $currentPage = request()->get('page', 1);
        $itemsPerPage = 5;
        $startNumber = ($currentPage - 1) * $itemsPerPage + 1;

        return view('post-dashboard.log_aktivitas.laporan', compact('materi', 'tanggal', 'startNumber'));
    }
}

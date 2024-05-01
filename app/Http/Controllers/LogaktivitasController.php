<?php

namespace App\Http\Controllers;

use App\Models\Logaktivitas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LogaktivitasController extends Controller
{
    public function logaktivitas()
    {
        // Mengambil data admin yang sedang login
        $admin = Auth::guard('admin')->user();
        // Mengambil semua data materi dari database beserta relasi Kategori dan Coach
        $logaktivitas = Logaktivitas::with('member', 'materi')->get();
        return view('post-dashboard.log_aktivitas.log_aktivitas', compact('logaktivitas', 'admin'));
    }
}

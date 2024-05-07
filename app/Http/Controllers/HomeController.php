<?php

namespace App\Http\Controllers;

use App\Models\Coach;
use App\Models\Materi;
use App\Models\Member;
use App\Models\Logaktivitas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    // /**
    //  * Create a new controller instance.
    //  *
    //  * @return void
    //  */
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }

    // /**
    //  * Show the application dashboard.
    //  *
    //  * @return \Illuminate\Contracts\Support\Renderable
    //  */
    public function index()
    {
        // Mengambil data admin yang sedang login
        $admin = Auth::guard('admin')->user();

        // Menghitung jumlah materi
        $jumlahMateri = Materi::count();

        // Menghitung jumlah coach
        $jumlahCoach = Coach::count();

        // Menghitung jumlah member
        $jumlahMember = Member::count();

        // Mengambil semua data materi dari database beserta relasi Kategori dan Coach
        $logaktivitas = Logaktivitas::with('member', 'materi')->get();

        // Mengirimkan data ke view
        return view('post-dashboard.dashboard', compact('logaktivitas', 'admin', 'jumlahMateri', 'jumlahCoach', 'jumlahMember'));
    }
}

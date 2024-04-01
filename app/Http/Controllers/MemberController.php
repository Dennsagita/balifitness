<?php

namespace App\Http\Controllers;

use App\Models\Member;
use Illuminate\Http\Request;

class MemberController extends Controller
{
    public function index()
    {
        $member = Member::all();
        return view('post-dashboard.member.member', compact('member'));
    }

    // Halaman Dashboard Untuk Akun Coach
    public function member()
    {
        return view('post-dashboard.member-dashboard.materi-member');
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
}

<?php

namespace App\Http\Controllers;

use App\Models\Member;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function index()
    {
        return view('login');
    }

    public function proseslogin(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ], [
            'email.required' => 'Email harus diisi.',
            'email.email' => 'Data yang di input tidak berupa email',
            'password.required' => 'Password harus diisi.',
        ]);

        if (Auth::guard('admin')->attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended(route('dashboard'));
        } else if (Auth::guard('member')->attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended(route('materi-member'));
        } else if (Auth::guard('coach')->attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended(route('materi-coach'));
        }
        return back()->withErrors([
            'gagal-login' => 'Email atau password Tidak Sesuai',
        ])->onlyInput('email');
    }

    // Untuk registrasi member
    public function registrasi()
    {
        return view('registrasi');
    }

    public function prosesregistrasi(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'no_telp' => 'required|numeric',
            'alamat' => 'required',
            'email' => 'required|unique:users',
            'password' => 'required',
            'password_confirm' => 'required|same:password',
        ], [
            'nama.required' => 'Nama harus diisi.',
            'no_telp.required' => 'Nomor Telphone harus diisi.',
            'no_telp.numeric' => 'Nomor harus berupa angka .',
            'alamat.required' => 'Alamat harus diisi.',
            'email.required' => 'email harus diisi.',
            'email.email' => 'Data yang di input tidak berupa email',
            'password.required' => 'Password harus diisi.',
            'password_confirm.required' => 'Konfirmasi Password harus diisi.',
            'password_confirm.same' => 'Konfirmasi Password Tidak Sama Dengan Password',
        ]);

        $user = new Member([
            'nama' => $request->nama,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'alamat' => $request->alamat,
            'no_telp' => $request->no_telp,

        ]);

        $user->save();
        return redirect()->route('login')->with('registrasi', 'Berhasil Melakukan Registrasi, Silakan Login');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerate();
        return redirect()->route('login')->with('logout', 'Berhasil Logout');
    }
}

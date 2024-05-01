<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Coach;
use App\Models\Member;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Password;

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

    public function ubahpassword(Request $request)
    {

        $request->validate([
            'old_password' => 'required|current_password',
            'new_password' => 'required',
            'new_password_confirm' => 'required|same:new_password',
        ], [
            'old_password.required' => 'Password lama harus diisi.',
            'new_password.required' => 'Password baru harus diisi.',
            'new_password_confirm.required' => 'Konfirmasi Password harus diisi.',
            'new_password_confirm.same' => 'Konfirmasi Password harus sama dengan Password baru.',
        ]);


        if (Str::length(Auth::guard('admin')->user()) > 0) {
            $admin = Admin::find(Auth::id());
            $admin->password = Hash::make($request->new_password);
            $admin->save();
            // Logout pengguna setelah berhasil update password
            Auth::guard('admin')->logout();
            // $request->session()->regenerate();
            return redirect()->route('login')->with('ubahPassword', 'Password Berhasil Diubah');
        } elseif (Str::length(Auth::guard('member')->user()) > 0) {
            $member = Member::find(Auth::id());
            $member->password = Hash::make($request->new_password);
            $member->save();
            // Logout pengguna setelah berhasil update password
            Auth::guard('member')->logout();
            // $request->session()->regenerate();
            return redirect()->route('login')->with('ubahPassword', 'Password Berhasil Diubah');
        } elseif (Str::length(Auth::guard('coach')->user()) > 0) {
            $coach = Coach::find(Auth::id());
            $coach->password = Hash::make($request->new_password);
            $coach->save();
            // Logout pengguna setelah berhasil update password
            Auth::guard('coach')->logout();
            // $request->session()->regenerate();
            return redirect()->route('login')->with('ubahPassword', 'Password Berhasil Diubah');
        }
    }
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerate();
        return redirect()->route('login')->with('logout', 'Berhasil Logout');
    }

    public function lupaPassword()
    {
        return view('resetpassword');
    }

    public function processLupaPassword(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        // Cek apakah email ada pada tabel Member
        $member = Member::where('email', $request->email)->first();

        // Cek apakah email ada pada tabel adminlog jika belum ada di tabel member
        if (!$member) {
            $admin = Admin::where('email', $request->email)->first();
        }

        // Cek apakah email ada pada tabel Admin jika belum ada di tabel User atau Pengemudi
        if (!$member && !$admin) {
            $coach = Coach::where('email', $request->email)->first();
        }

        // Jika email ada pada tabel member, gunakan metode sendResetLink untuk tabel member
        if ($member) {
            $status = Password::broker('member')->sendResetLink(
                $request->only('email')
            );
        } elseif ($admin) {
            // Jika email ada pada tabel admin, gunakan metode sendResetLink untuk tabel Pengemudi
            $status = Password::broker('admin')->sendResetLink(
                $request->only('email')
            );
        } elseif ($coach) {
            // Jika email ada pada tabel admin, gunakan metode sendResetLink untuk tabel Pengemudi
            $status = Password::broker('coach')->sendResetLink(
                $request->only('email')
            );
        } else {
            // Jika email tidak ada di semua tabel, kembalikan dengan pesan error
            return back()->withErrors(['email' => 'Email tidak ditemukan']);
        }

        if ($status) {
            Session::flash('reset', 'Berhasil melakukan reset password, cek email anda untuk melakukan proses selanjutnya');
        }
        return $status === Password::RESET_LINK_SENT
            ? back()->with(['status' => __($status)])
            : back()->withErrors(['email' => __($status)]);
    }

    public function resetPassword($token)
    {
        return view('reset-password', ['token' => $token]);
    }

    public function processResetPassword(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:3|confirmed',
        ]);

        $member = Member::where('email', $request->email)->first();
        $admin = Admin::where('email', $request->email)->first();
        $coach = Coach::where('email', $request->email)->first();

        if ($member) {
            $status = Password::broker('member')->reset(
                $request->only('email', 'password', 'password_confirmation', 'token'),
                function ($member, $password) {
                    $member->forceFill([
                        'password' => Hash::make($password)
                    ])->setRememberToken(Str::random(60));

                    $member->save();

                    event(new \Illuminate\Auth\Events\PasswordReset($member));
                }
            );
        } elseif ($admin) {
            $status = Password::broker('admin')->reset(
                $request->only('email', 'password', 'password_confirmation', 'token'),
                function ($admin, $password) {
                    $admin->forceFill([
                        'password' => Hash::make($password)
                    ])->setRememberToken(Str::random(60));

                    $admin->save();
                    event(new \Illuminate\Auth\Events\PasswordReset($admin));
                }
            );
        } elseif ($coach) {
            $status = Password::broker('coach')->reset(
                $request->only('email', 'password', 'password_confirmation', 'token'),
                function ($coach, $password) {
                    $coach->forceFill([
                        'password' => Hash::make($password)
                    ])->setRememberToken(Str::random(60));

                    $coach->save();
                    event(new \Illuminate\Auth\Events\PasswordReset($coach));
                }
            );
        } else {
            // Jika email tidak ditemukan dalam ketiga tabel, tampilkan pesan error
            return back()->withErrors(['email' => 'Email not found']);
        }

        return $status === Password::PASSWORD_RESET
            ? redirect()->route('login')->with('status', 'Berhasil Reset Password')
            : back()->withErrors(['email' => 'Token Reset Password Tidak Valid']);
    }
}

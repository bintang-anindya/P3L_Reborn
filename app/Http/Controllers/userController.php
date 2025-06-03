<?php

namespace App\Http\Controllers;

use App\Models\Alamat;
use App\Models\Pembeli;
use App\Models\Organisasi;
use App\Models\Pegawai;
use App\Models\Penitip;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;


class UserController extends Controller
{
    // Menampilkan halaman register
    public function showRegisterForm()
    {
        return view('auth.register');
    }

    public function showChangePasswordForm()
    {
        return view('auth.changePassword');
    }

    // Proses registrasi
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:pembeli,username_pembeli|unique:organisasi,username_organisasi',
            'email' => 'required|string|email|max:255|unique:pembeli,email_pembeli|unique:organisasi,email_organisasi',
            'password' => 'required|string|min:6|confirmed',
            'phone' => 'required|string|min:10|max:20',
            'alamat' => 'required|string',
            'role' => 'required|in:pembeli,organisasi',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        if ($request->role === 'pembeli') {
            $pembeli = Pembeli::create([
                'nama_pembeli' => $request->nama,
                'username_pembeli' => $request->username,
                'email_pembeli' => $request->email,
                'password_pembeli' => $request->password,
                'no_telp_pembeli' => $request->phone,
                'poin_pembeli' => 0,
            ]);

            $alamat = Alamat::create([
                'detail' => $request->alamat,
                'user_id' => $pembeli->id,
            ]);

            $pembeli->update(['id_alamat' => $alamat->id]);

        } elseif ($request->role === 'organisasi') {
            Organisasi::create([
                'nama_organisasi' => $request->nama,
                'username_organisasi' => $request->username,
                'email_organisasi' => $request->email,
                'password_organisasi' => $request->password,
                'alamat_organisasi' => $request->alamat,
                'no_telp_organisasi' => $request->phone,
            ]);
        }

        return redirect()->route('login')->with('success', 'Registrasi berhasil! Silakan login.');
    }

    // Menampilkan halaman login
    public function showLoginForm()
    {
        return view('auth.login');
    }

    // Proses login
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // 2. Login sebagai Pembeli
        $pembeli = Pembeli::where('email_pembeli', $request->email)->first();

        // Login untuk pembeli
        if ($pembeli && $request->password === $pembeli->password_pembeli) {
            Auth::guard('pembeli')->login($pembeli);
            // session()->flush();
            session(['guard' => 'pembeli']); // Menyimpan status guard ke session
            Log::info('User logged in successfully as Pembeli', ['user' => $pembeli->id_pembeli]);
            Log::info('Guard aktif sekarang:', ['guard' => Auth::guard('pembeli')->getName()]);
            session(['pembeli_id' => $pembeli->id_pembeli]);
            return redirect()->route('dashboard.pembeli');  // Pastikan redirect yang benar
        }

        // 1. Login sebagai Pegawai
        $pegawai = Pegawai::with('role')->where('email_pegawai', $request->email)->first();
        if ($pegawai && $request->password === $pegawai->password_pegawai) {
            Auth::guard('pegawai')->login($pegawai); 
            session(['guard' => 'pegawai']);
            session(['role' => $pegawai->role->nama_role]);
                
            Log::info('User logged in successfully as Pegawai', ['user' => $pegawai->id_pegawai]);
            Log::info('Session Guard:', ['guard' => session('guard')]);
            Log::info('Current User Pegawai:', ['user' => Auth::guard('pegawai')->user()]);

            return match ($pegawai->role->nama_role) {
                'cs' => redirect()->route('dashboard.cs'),
                'gudang' => redirect()->route('dashboard.gudang'),
                'admin' => redirect()->route('dashboard.admin'),
                'hunter' => redirect()->route('dashboard.hunter'),
                'owner' => redirect()->route('dashboard.owner'),
                default => redirect()->route('login')->withErrors(['login_error' => 'Role tidak valid.']),
            };
        }

        // 3. Login sebagai Organisasi
        $organisasi = Organisasi::where('email_organisasi', $request->email)->first();
        if ($organisasi && $request->password === $organisasi->password_organisasi) {
            // Auth::login($organisasi);
            Auth::guard('organisasi')->login($organisasi);
            session(['guard' => 'organisasi']); // Menyimpan status guard ke session
            Log::info('User logged in successfully as Pembeli', ['user' => $organisasi->id_organisasi]);
            Log::info('Guard aktif sekarang:', ['guard' => Auth::guard('organisasi')->getName()]);
            session(['organisasi_id' => $organisasi->id_organisasi]);
            return redirect()->route('dashboard.organisasi');  // Pastikan redirect yang benar
        }

        // 3. Login sebagai Penitip
        $penitip = Penitip::where('email_penitip', $request->email)->first();
        if ($penitip && $request->password === $penitip->password_penitip) {
            // Auth::login($organisasi);
            Auth::guard('penitip')->login($penitip);
            session(['guard' => 'penitip']); // Menyimpan status guard ke session
            Log::info('User logged in successfully as Penitip', ['user' => $penitip->id_penitip]);
            Log::info('Guard aktif sekarang:', ['guard' => Auth::guard('penitip')->getName()]);
            return redirect()->route('dashboard.penitip');  // Pastikan redirect yang benar
        }

        // Jika login gagal
        return back()->withErrors(['login_error' => 'Email atau password salah.'])->withInput();
    }

    // Logout
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home')->with('success', 'Berhasil logout.');
    }

    public function showResetPasswordPegawai()
    {
        $pegawaiList = Pegawai::all();
        return view('auth.resetPasswordPegawai', compact('pegawaiList'));
    }

    public function resetPasswordPegawai($id)
    {   
        $pegawai = Pegawai::findOrFail($id);

        if ($pegawai) {
            $pegawai->password_pegawai = $pegawai->tanggal_lahir; // plain text
            $pegawai->save();

            return redirect()->back()->with('success', 'Password pegawai berhasil direset ke tanggal lahir.');
        }

        return redirect()->back()->with('error', 'Pegawai tidak ditemukan.');
    }

}
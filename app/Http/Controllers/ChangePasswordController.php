<?php

namespace App\Http\Controllers;

use App\Models\Pegawai;
use App\Models\Pembeli;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;
use App\Mail\ResetPasswordMail;

class ChangePasswordController extends Controller
{
    public function showForm()
    {
        return view('auth.changePassword');
    }

    public function changePasswordSubmit(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'role' => 'required|in:owner,admin,cs,gudang,pembeli',
        ]);

        $user = null;
        $routeTo = '';

        // Cek apakah user sesuai role dan email ditemukan
        if ($request->role === 'pembeli') {
            $user = Pembeli::where('email_pembeli', $request->email)->first();

            if ($user) {
                // Buat signed URL lengkap
                $url = URL::signedRoute('resetPassword', [
                    'email' => $request->email,
                    'role' => $request->role
                ]);

                Mail::to($request->email)->send(new ResetPasswordMail($url));

                return back()->with('status', 'Link reset password telah dikirim ke email Anda.');
            } else {
                return back()->withErrors(['email' => 'Akun dengan email tersebut tidak ditemukan.']);
            }
        } else {
            $user = Pegawai::where('email_pegawai', $request->email)
                ->whereHas('role', function ($query) use ($request) {
                    $query->where('nama_role', $request->role); // Pastikan nama kolom yang tepat
                })
                ->first();

            if ($user) {
                // Update password menggunakan tanggal_lahir
                $user->password_pegawai = $user->tanggal_lahir; // Gunakan tanggal_lahir sesuai permintaan
                $user->save();

                // Arahkan ke dashboard sesuai role
                return redirect()->route('dashboard.' . $request->role); 
            } else {
                return back()->withErrors(['email' => 'Akun dengan email dan role tersebut tidak ditemukan.']);
            }

        }

        if (!$user) {
            return back()->withErrors(['email' => 'Akun dengan email dan role tersebut tidak ditemukan.']);
        }

        // Redirect ke halaman reset password jika role = pembeli
        return redirect($routeTo)->with('status', 'Silakan masukkan password baru Anda.');
    }

    public function showResetForm(Request $request)
    {
        // Validasi jika URL memiliki tanda tangan yang valid
        if (!$request->hasValidSignature()) {
            abort(403, 'Link reset tidak valid atau sudah kedaluwarsa.');
        }   

        // Jika URL valid, lanjutkan untuk menampilkan form reset password
        return view('auth.resetPassword', [
            'email' => $request->email,
            'role' => $request->role,
        ]);
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'role' => 'required|in:pembeli',
            'password' => 'required|min:8|confirmed',
        ]);

        $user = Pembeli::where('email_pembeli', $request->email)->first();

        if (!$user) {
            return back()->withErrors(['email' => 'Akun tidak ditemukan.']);
        }

        $user->password_pembeli = $request->password; // plain text, sesuai permintaan
        $user->save();

        return redirect()->route('loginPage')->with('success', 'Password berhasil diubah.');
    }
}

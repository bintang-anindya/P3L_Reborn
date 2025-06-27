<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Penitip;
use App\Models\Barang;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;


class PenitipController extends Controller
{
    public function index(Request $request)
    {
        $query = Penitip::query();

        if ($request->filled('keyword')) {
            $keyword = $request->keyword;
            $query->where(function ($q) use ($keyword) {
                $q->where('nama_penitip', 'like', "%$keyword%")
                  ->orWhere('username_penitip', 'like', "%$keyword%")
                  ->orWhere('nik', 'like', "%$keyword%");
            });
        }

        $penitips = $query->paginate(10);
        return view('cs.dataPenitip', compact('penitips'));
    }
    // public function index(Request $request)
    // {
    //     $guard = session('guard');

    //     if ($guard == 'penitip') {
    //         $user = Auth::guard('penitip')->user();
    //         $penitip = $user;

    //         return view('penitip.penarikan', compact(
    //             'user',
    //             'penitip',
    //         ));

    //     } 
    // }

    public function store(Request $request)
    {
        $request->validate([
            'nama_penitip' => 'required|string',
            'username_penitip' => 'required|string|unique:penitip',
            'password_penitip' => 'required|string|min:6',
            'nik' => 'required|numeric|unique:penitip,nik',
            'email_penitip' => 'nullable|email',
            'no_telp_penitip' => 'nullable|string',
            'foto_ktp' => 'required|image|max:2048',
        ], [
            'username_penitip.unique' => 'Username sudah digunakan.',
            'nik.unique' => 'NIK tidak boleh sama dengan penitip lain.',
        ]);

        $path = $request->file('foto_ktp')->store('ktp', 'public');

        Penitip::create([
            'nama_penitip' => $request->nama_penitip,
            'username_penitip' => $request->username_penitip,
            'password_penitip' => Hash::make($request->password_penitip),
            'nik' => $request->nik,
            'email_penitip' => $request->email_penitip,
            'no_telp_penitip' => $request->no_telp_penitip,
            'foto_ktp' => $path,
            'poin_penitip'=> 0,
            'saldo_penitip'=> 0,
        ]);

        return redirect()->route('cs.penitip.index')->with('success', 'Penitip berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        $penitip = Penitip::findOrFail($id);

        $request->validate([
            'nama_penitip' => 'required|string',
            'username_penitip' => 'required|string|unique:penitip,username_penitip,' . $id . ',id_penitip',
            'nik' => 'required|numeric|unique:penitip,nik,' . $id . ',id_penitip',
            'email_penitip' => 'nullable|email',
            'no_telp_penitip' => 'nullable|string',
            'foto_ktp' => 'nullable|image|max:2048',
        ], [
            'username_penitip.unique' => 'Username sudah digunakan.',
            'nik.unique' => 'NIK tidak boleh sama dengan penitip lain.',
        ]);

        $data = $request->only(['nama_penitip', 'username_penitip', 'nik', 'email_penitip', 'no_telp_penitip']);

        if ($request->filled('password_penitip')) {
            $data['password_penitip'] = Hash::make($request->password_penitip);
        }

        if ($request->hasFile('foto_ktp')) {
            if ($penitip->foto_ktp && Storage::disk('public')->exists($penitip->foto_ktp)) {
                Storage::disk('public')->delete($penitip->foto_ktp);
            }

            $data['foto_ktp'] = $request->file('foto_ktp')->store('ktp', 'public');
        }

        $penitip->update($data);

        return redirect()->route('cs.penitip.index')->with('success', 'Penitip berhasil diupdate.');
    }

    public function edit($id)
    {
        $penitip = Penitip::findOrFail($id);
        $penitips = Penitip::paginate(10); 
        return view('cs.dataPenitip', compact('penitips', 'penitip'));
    }

    public function destroy($id)
    {
        $penitip = Penitip::findOrFail($id);

        // Cek apakah penitip pernah melakukan penitipan
        $hasPenitipan = \App\Models\Penitipan::where('id_penitip', $penitip->id_penitip)->exists();

        if ($hasPenitipan) {
            return redirect()->route('cs.penitip.index')
                ->with('error', 'Penitip tidak dapat dihapus karena sudah pernah melakukan penitipan.');
        }

        // Hapus foto KTP jika ada
        if ($penitip->foto_ktp && Storage::disk('public')->exists($penitip->foto_ktp)) {
            Storage::disk('public')->delete($penitip->foto_ktp);
        }

        $penitip->delete();

        return redirect()->route('cs.penitip.index')->with('success', 'Penitip berhasil dihapus.');
    }

    public function tariksaldo(Request $request, $id)
    {
        $penitip = Penitip::findOrFail($id);

        $request->validate([
            'nominal_tarik' => ['required','numeric','min:1',
                function ($attribute, $value, $fail) use ($penitip) {
                    if ($value > $penitip->saldo_penitip) {
                        $fail('Nominal penarikan tidak boleh melebihi saldo yang tersedia.');
                        return redirect()->route('penitip.penarikan')->with('error', 'Saldo anda kurang');
                    }
                },
            ],
        ], [
            'nominal_tarik.required' => 'Nominal penarikan wajib diisi.',
            'nominal_tarik.numeric' => 'Nominal penarikan harus berupa angka.',
            'nominal_tarik.min' => 'Nominal penarikan harus minimal 1.',
        ]);

        $penitip->saldo_penitip -= $request->nominal_tarik + $request->nominal_tarik*5/100;
        $penitip->nominal_tarik = $request->nominal_tarik;

        $penitip->save();

        Log::info('Penarikan Saldo Berhasil', [
            'penitip_id' => $penitip->id_penitip,
            'nominal_tarik' => $request->nominal_tarik,
            'saldo_setelah_tarik' => $penitip->saldo_penitip,
        ]);

        return redirect()->route('penitip.penarikan')->with('success', 'Penarikan berhasil dilakukan.');
    }
}
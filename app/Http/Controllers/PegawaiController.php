<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pegawai;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;


class PegawaiController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->search;
        
        $pegawaiQuery = Pegawai::with('role');
        
        if ($search) {
            $pegawaiQuery->where(function($query) use ($search) {
                $query->where('nama_pegawai', 'like', "%{$search}%")
                      ->orWhereHas('role', function($q) use ($search) {
                          $q->where('nama_role', 'like', "%{$search}%");
                      });
            });
        }
        
        $pegawaiList = $pegawaiQuery->get();
        $roles = Role::all();
        
        return view('dashboard.admin', compact('pegawaiList', 'roles', 'search'));
    }

    public function indexOwner(Request $request)
    {        
        $owner = Auth::guard('pegawai')->user();
        if (!$owner) {
            return redirect()->route('login')->withErrors(['message' => 'Anda belum login sebagai owner.']);
        }
        
        return view('dashboard.owner', compact('owner'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_pegawai' => 'required',
            'email_pegawai' => 'required|email|unique:pegawai,email_pegawai',
            'username_pegawai' => 'required|unique:pegawai,username_pegawai',
            'password_pegawai' => 'required|min:6',
            'no_telp_pegawai' => 'required|numeric',
            'id_role' => 'required|exists:role,id_role',
        ]);

        $data = $request->all();
        $data['password_pegawai'] = Hash::make($request->password_pegawai);
        
        Pegawai::create($data);
        
        return redirect()->route('pegawai.index')
                         ->with('success', 'Data pegawai berhasil ditambahkan');
    }

    public function edit($id)
    {
        $pegawai = Pegawai::findOrFail($id);
        $roles = Role::all();
        $editMode = true;
        $pegawaiList = Pegawai::with('role')->get();
        
        return view('dashboard.admin', compact('pegawai', 'roles', 'editMode', 'pegawaiList'));
    }

    public function update(Request $request, $id)
    {
        $pegawai = Pegawai::findOrFail($id);

        $rules = [
            'nama_pegawai' => 'required',
            'email_pegawai' => 'required|email|unique:pegawai,email_pegawai,' . $id . ',id_pegawai',
            'username_pegawai' => 'required|unique:pegawai,username_pegawai,' . $id . ',id_pegawai',
            'no_telp_pegawai' => 'required|numeric',
            'id_role' => 'required|exists:role,id_role',
        ];
        
        if ($request->filled('password_pegawai')) {
            $rules['password_pegawai'] = 'min:6';
        }
        
        $request->validate($rules);

        $data = $request->except(['password_pegawai']);
        
        if ($request->filled('password_pegawai')) {
            $data['password_pegawai'] = Hash::make($request->password_pegawai);
        }
        
        $pegawai->update($data);
        
        return redirect()->route('pegawai.index')
                         ->with('success', 'Data pegawai berhasil diperbarui');
    }

    public function destroy($id)
    {
        try {
            $pegawai = Pegawai::findOrFail($id);
            $pegawai->delete();
            return redirect()->route('pegawai.index')
                             ->with('success', 'Data pegawai berhasil dihapus');
        } catch (\Exception $e) {
            return redirect()->route('pegawai.index')
                             ->with('error', 'Gagal menghapus data pegawai');
        }
    }
}
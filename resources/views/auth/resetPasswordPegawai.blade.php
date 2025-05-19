@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Reset Password Pegawai</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Nama Pegawai</th>
                <th>Email</th>
                <th>Reset Password</th>
            </tr>
        </thead>
        <tbody>
            @foreach($pegawaiList as $pegawai)
                <tr>
                    <td>{{ $pegawai->nama_pegawai }}</td>
                    <td>{{ $pegawai->email_pegawai }}</td>
                    <td>
                        <form action="{{ route('pegawai.resetPassword.submit', $pegawai->id_pegawai) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-warning" onclick="return confirm('Yakin reset password ke tanggal lahir?')">
                                Reset ke Tanggal Lahir
                            </button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection

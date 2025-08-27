@extends('layouts.app')

@section('content')
<div class="card shadow-lg">
    <div class="card-header bg-primary text-white">
        <h4>Detail Lamaran</h4>
    </div>
    <div class="card-body bg-light">
        <p><b>Nama:</b> {{ $pelamar->nama_lengkap }}</p>
        <p><b>Posisi:</b> {{ $pelamar->job->posisi }}</p>
        <p><b>Pendidikan:</b> {{ $pelamar->pendidikan_terakhir }}</p>
        <p><b>Email:</b> {{ $pelamar->email }}</p>
        <p><b>No HP:</b> {{ $pelamar->no_hp }}</p>
        <p><b>Alamat:</b> {{ $pelamar->alamat }}</p>

        <h5 class="mt-3 text-primary">Pengalaman Kerja</h5>
        @forelse($pelamar->pengalamanKerja as $exp)
            <div class="border p-2 rounded mb-2 bg-white">
                <p><b>{{ $exp->nama_perusahaan }}</b> ({{ $exp->tahun_mulai }} - {{ $exp->tahun_selesai }})</p>
                <p>Posisi: {{ $exp->posisi }}</p>
                <p>Alasan Resign: {{ $exp->alasan_resign }}</p>
            </div>
        @empty
            <p class="text-muted">Tidak ada pengalaman kerja.</p>
        @endforelse

        <div class="mt-4 text-end">
            <a href="{{ route('pelamar.create') }}" class="btn btn-warning">Kembali</a>

            @php
                $noWa = "6285726339392"; // 62 biar format internasional
                $pesan = "Halo, perkenalkan saya ".$pelamar->nama_lengkap.
                         ". Saya telah mendaftar pada posisi ".$pelamar->job->posisi.
                         ", saya tunggu untuk info selanjutnya. Besar harapan saya untuk bergabung di perusahaan ini. Terimakasih";
                $linkWa = "https://wa.me/".$noWa."?text=".urlencode($pesan);
            @endphp

            <a href="{{ $linkWa }}" target="_blank" class="btn btn-success">Lanjut Verifikasi</a>
        </div>
    </div>
</div>
@endsection
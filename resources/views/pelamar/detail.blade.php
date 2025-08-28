@extends('layouts.app')

@section('content')
<div class="card shadow-lg">
    <div class="card-header bg-primary text-white">
        <h4>Detail Lamaran</h4>
    </div>
    <div class="card-body bg-light">
        <p><b>Nama:</b> {{ $pelamar->nama_lengkap }}</p>
        <p><b>Posisi:</b> {{ $pelamar->job->posisi ?? '-' }}</p>
        <p><b>Pendidikan:</b> {{ $pelamar->pendidikan_terakhir }}</p>
        <p><b>Email:</b> {{ $pelamar->email }}</p>
        <p><b>No HP:</b> {{ $pelamar->no_hp }}</p>
        <p><b>Alamat:</b> {{ $pelamar->alamat }}</p>

        {{-- 🔹 Tambahan untuk lihat berkas --}}
        @if($pelamar->upload_berkas)
        <p><b>Berkas:</b>
            <a href="{{ asset('storage/'.$pelamar->upload_berkas) }}" target="_blank" class="btn btn-sm btn-outline-info">Lihat / Download</a>
        </p>
        @endif

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
            $noWa = "6285726339392"; // nomor tujuan
            $pesan = "Halo HRD,%0A%0A"
            . "Perkenalkan saya ".$pelamar->nama_lengkap.".%0A"
            . "Saya melamar posisi ".$pelamar->job->posisi.".%0A"
            . "Terimakasih 🙏";


            // Gunakan rawurlencode biar aman
            $linkWa = "https://api.whatsapp.com/send?phone=".$noWa."&text=".rawurlencode($pesan);
            @endphp

            <a href="{{ $linkWa }}" target="_blank" class="btn btn-success">Lanjut Verifikasi</a>


        </div>
    </div>
</div>
@endsection
@extends('layouts.app')

@section('content')
<div class="container my-5">
    <div class="card shadow-lg border-0 rounded-3">
        <div class="card-header bg-primary text-white text-center">
            <h3 class="mb-0">Form Pendaftaran Pelamar</h3>
        </div>

        {{-- 🔹 Tambah container scroll --}}
        <div class="card-body bg-light" style="max-height: 80vh; overflow-y: auto;">
            <form method="POST" action="{{ route('pelamar.store') }}" enctype="multipart/form-data">
                @csrf

                {{-- DATA PRIBADI --}}
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label">Nama Lengkap</label>
                        <input type="text" name="nama_lengkap" class="form-control"
                            placeholder="Nama Lengkap" value="{{ old('nama_lengkap') }}" required>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Tempat Lahir</label>
                        <input type="text" name="tempat_lahir" class="form-control"
                            placeholder="Tempat" value="{{ old('tempat_lahir') }}" required>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Tanggal Lahir</label>
                        <input type="date" name="tanggal_lahir" class="form-control"
                            value="{{ old('tanggal_lahir') }}" required>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-3">
                        <label class="form-label">Umur</label>
                        <input type="number" name="umur" class="form-control"
                            placeholder="Usia" value="{{ old('umur') }}" required>
                    </div>
                    <div class="col-md-9">
                        <label class="form-label">Posisi yang Dilamar</label>
                        <select name="id_job" class="form-select" required>
                            <option value="">-- Pilih Posisi --</option>
                            @foreach($jobs as $job)
                            <option value="{{ $job->id_job }}"
                                {{ (old('id_job') == $job->id_job || (isset($selectedJobId) && $selectedJobId == $job->id_job)) ? 'selected' : '' }}>
                                {{ $job->posisi }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label">No. HP</label>
                        <input type="text" name="no_hp" class="form-control"
                            placeholder="No HP" value="{{ old('no_hp') }}" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" class="form-control"
                            placeholder="Email" value="{{ old('email') }}" required>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Alamat</label>
                    <textarea name="alamat" class="form-control" rows="2" placeholder="Alamat" required>{{ old('alamat') }}</textarea>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label">Pendidikan Terakhir</label>
                        <select name="pendidikan_terakhir" class="form-select" required>
                            <option value="">-- Pilih Pendidikan --</option>
                            <option value="SD/MI" {{ old('pendidikan_terakhir') == 'SD/MI' ? 'selected' : '' }}>SD/MI</option>
                            <option value="SMP/MTS" {{ old('pendidikan_terakhir') == 'SMP/MTS' ? 'selected' : '' }}>SMP/MTS</option>
                            <option value="SMA/SMK/MA" {{ old('pendidikan_terakhir') == 'SMA/SMK/MA' ? 'selected' : '' }}>SMA/SMK/MA</option>
                            <option value="D3" {{ old('pendidikan_terakhir') == 'D3' ? 'selected' : '' }}>D3</option>
                            <option value="S1" {{ old('pendidikan_terakhir') == 'S1' ? 'selected' : '' }}>S1</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Sekolah / Universitas</label>
                        <input type="text" name="nama_sekolah" class="form-control"
                            placeholder="Sekolah / Universitas" value="{{ old('nama_sekolah') }}" required>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label">Pengetahuan Perusahaan</label>
                        <input type="text" name="pengetahuan_perusahaan" class="form-control"
                            placeholder="Pengetahuan" value="{{ old('pengetahuan_perusahaan') }}" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Ekspektasi Gaji</label>
                        <input type="text" name="ekspektasi_gaji" class="form-control"
                            placeholder="Ekspektasi Gaji" value="{{ old('ekspektasi_gaji') }}" required>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label">Kelebihan</label>
                        <input type="text" name="kelebihan" class="form-control"
                            placeholder="Kelebihan" value="{{ old('kelebihan') }}" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Kekurangan</label>
                        <input type="text" name="kekurangan" class="form-control"
                            placeholder="Kekurangan" value="{{ old('kekurangan') }}" required>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Sosial Media Aktif</label>
                    <input type="text" name="sosmed_aktif" class="form-control"
                        placeholder="Contoh: Instagram / LinkedIn" value="{{ old('sosmed_aktif') }}" required>
                </div>

                {{-- 🔹 FIELD TAMBAHAN --}}
                <div class="mb-3">
                    <label class="form-label">Bersediakah jika ditempatkan di lokasi manapun?</label>
                    <select name="bersedia_cilacap" class="form-select" required>
                        <option value="">-- Pilih --</option>
                        <option value="bersedia" {{ old('bersedia_cilacap') == 'bersedia' ? 'selected' : '' }}>Bersedia</option>
                        <option value="tidak" {{ old('bersedia_cilacap') == 'tidak' ? 'selected' : '' }}>Tidak</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Keahlian</label>
                    <textarea name="keahlian" class="form-control" rows="2" required>{{ old('keahlian') }}</textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label">Apakah Anda yakin bisa meyakinkan kami?</label>
                    <select name="alasan_merekrut" class="form-select" required>
                        <option value="">-- Pilih --</option>
                        <option value="yakin" {{ old('alasan_merekrut') == 'yakin' ? 'selected' : '' }}>Yakin</option>
                        <option value="tidak" {{ old('alasan_merekrut') == 'tidak' ? 'selected' : '' }}>Tidak</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Apa Kelebihan Anda dari kandidat lain?</label>
                    <textarea name="kelebihan_dari_yang_lain" class="form-control" rows="2" required>{{ old('kelebihan_dari_yang_lain') }}</textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label">Apakah Anda siap bekerja di bawah Target? Mengapa?</label>
                    <textarea name="alasan_bekerja_dibawah_tekanan" class="form-control" rows="2" required>{{ old('alasan_bekerja_dibawah_tekanan') }}</textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label">Kapan Anda bisa mulai bergabung dengan tim kami?</label>
                    <select name="kapan_bisa_gabung" class="form-select" required>
                        <option value="">-- Pilih --</option>
                        <option value="segera" {{ old('kapan_bisa_gabung') == 'segera' ? 'selected' : '' }}>Segera / ASAP</option>
                        <option value="bulan depan" {{ old('kapan_bisa_gabung') == 'bulan depan' ? 'selected' : '' }}>Bulan depan</option>
                        <option value="2 bulan lagi" {{ old('kapan_bisa_gabung') == '2 bulan lagi' ? 'selected' : '' }}>2 Bulan lagi</option>
                        <option value="3 bulan lagi" {{ old('kapan_bisa_gabung') == '3 bulan lagi' ? 'selected' : '' }}>3 Bulan lagi</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Mengapa Perusahaan harus memberikan gaji sesuai yang Anda harapkan?</label>
                    <textarea name="alasan_ekspektasi" class="form-control" rows="2" required>{{ old('alasan_ekspektasi') }}</textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label">Upload Berkas</label>
                    <input type="file" name="upload_berkas" class="form-control" required>
                </div>

                <hr>
                <h5 class="text-primary">Pengalaman Kerja</h5>
                <button type="button" class="btn btn-outline-primary btn-sm mb-3" onclick="tambahPengalaman()">+ Tambah Pengalaman</button>
                <div id="pengalaman-container">
                    @if(old('pengalaman'))
                    @foreach(old('pengalaman') as $idx => $exp)
                    <div class="card p-3 mb-3 shadow-sm pengalaman-item">
                        <h6 class="text-secondary">Pengalaman Kerja</h6>
                        <div class="row mb-2">
                            <div class="col-md-6">
                                <input type="text" name="pengalaman[{{ $idx }}][nama_perusahaan]"
                                    class="form-control" placeholder="Nama Perusahaan"
                                    value="{{ $exp['nama_perusahaan'] ?? '' }}" required>
                            </div>
                            <div class="col-md-6">
                                <input type="text" name="pengalaman[{{ $idx }}][posisi]"
                                    class="form-control" placeholder="Posisi"
                                    value="{{ $exp['posisi'] ?? '' }}" required>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-md-6">
                                <input type="number" name="pengalaman[{{ $idx }}][tahun_mulai]"
                                    class="form-control" placeholder="Tahun Masuk"
                                    value="{{ $exp['tahun_mulai'] ?? '' }}" required>
                            </div>
                            <div class="col-md-6">
                                <input type="number" name="pengalaman[{{ $idx }}][tahun_selesai]"
                                    class="form-control" placeholder="Tahun Resign"
                                    value="{{ $exp['tahun_selesai'] ?? '' }}" required>
                            </div>
                        </div>
                        <div class="mb-2">
                            <textarea name="pengalaman[{{ $idx }}][pengalaman]" class="form-control"
                                rows="2" placeholder="Deskripsi Pekerjaan" required>{{ $exp['pengalaman'] ?? '' }}</textarea>
                        </div>
                        <div class="mb-2">
                            <textarea name="pengalaman[{{ $idx }}][alasan_resign]" class="form-control"
                                rows="2" placeholder="Alasan Resign" required>{{ $exp['alasan_resign'] ?? '' }}</textarea>
                        </div>
                        <button type="button" class="btn btn-sm btn-danger" onclick="hapusPengalaman(this)">Hapus</button>
                    </div>
                    @endforeach
                    @endif
                </div>

                <div class="text-end">
                    <button type="submit" class="btn btn-primary px-4">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function tambahPengalaman() {
        let container = document.getElementById('pengalaman-container');
        let idx = Date.now();
        let div = document.createElement('div');
        div.classList.add("card", "p-3", "mb-3", "shadow-sm", "pengalaman-item");
        div.innerHTML = `
        <h6 class="text-secondary">Pengalaman Kerja</h6>
        <div class="row mb-2">
            <div class="col-md-6">
                <input type="text" name="pengalaman[${idx}][nama_perusahaan]" class="form-control" placeholder="Nama Perusahaan" required>
            </div>
            <div class="col-md-6">
                <input type="text" name="pengalaman[${idx}][posisi]" class="form-control" placeholder="Posisi" required>
            </div>
        </div>
        <div class="row mb-2">
            <div class="col-md-6">
                <input type="number" name="pengalaman[${idx}][tahun_mulai]" class="form-control" placeholder="Tahun Masuk" required>
            </div>
            <div class="col-md-6">
                <input type="number" name="pengalaman[${idx}][tahun_selesai]" class="form-control" placeholder="Tahun Resign" required>
            </div>
        </div>
        <div class="mb-2">
            <textarea name="pengalaman[${idx}][pengalaman]" class="form-control" rows="2" placeholder="Deskripsi Pekerjaan" required></textarea>
        </div>
        <div class="mb-2">
            <textarea name="pengalaman[${idx}][alasan_resign]" class="form-control" rows="2" placeholder="Alasan Resign" required></textarea>
        </div>
        <button type="button" class="btn btn-sm btn-danger" onclick="hapusPengalaman(this)">Hapus</button>
    `;
        container.appendChild(div);
    }

    function hapusPengalaman(btn) {
        let card = btn.closest('.pengalaman-item');
        card.remove();
    }
</script>
@endsection

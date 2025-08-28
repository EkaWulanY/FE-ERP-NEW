<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Pendaftaran Pelamar</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap');

        body {
            font-family: 'Inter', sans-serif;
            background-color: #e5e7eb;
        }

        .hover-effect-btn:hover {
            background-color: #4E71FF;
            transition: background-color 0.3s ease;
        }
    </style>
</head>

<body class="bg-gray-200">

    {{-- HEADER --}}
    <div class="bg-[#072A75] text-white p-4 flex justify-between items-center shadow-lg">
        <div class="flex items-center">
            <img src="{{ asset('admin/img/logo.jpg') }}" alt="Logo" class="h-8 w-8 mr-2 rounded-full">
            <span class="text-xl font-bold">Sistem ERP HR</span>
        </div>
        <div class="flex items-center">
            <span class="mr-2">Admin</span>
            <svg class="h-8 w-8 rounded-full border-2 border-white" fill="none" viewBox="0 0 24 24"
                stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M5.121 17.804A7.962 7.962 0 0112 15a7.962 7.962 0 016.879 2.804M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
            </svg>
        </div>
    </div>

    {{-- NAVBAR --}}
    <div class="container mx-auto p-8">
        <div class="flex justify-center space-x-4 mb-8">
            <a href="{{ route('admin.jobs.list') }}"
                class="bg-purple-300 text-white font-semibold py-2 px-6 rounded-lg shadow-lg hover-effect-btn">List Job</a>
            <a href="{{ route('admin.pelamar.list') }}"
                class="bg-purple-300 text-white font-semibold py-2 px-6 rounded-lg shadow-lg hover-effect-btn">Data Pelamar</a>
            <a href="{{ route('admin.form.lamaran') }}"
                class="bg-purple-300 text-white font-semibold py-2 px-6 rounded-lg shadow-lg hover-effect-btn">Edit Form Daftar</a>
            <a href="{{ asset('finger/finger.php') }}"
                class="bg-purple-300 text-white font-semibold py-2 px-6 rounded-lg shadow-lg hover-effect-btn">Absensi</a>
        </div>

        {{-- FORM PENDAFTARAN --}}
        <div class="bg-white p-8 rounded-2xl shadow-lg max-h-screen overflow-y-auto">
            <h2 class="text-2xl font-bold text-center text-[#072A75] mb-6">Form Pendaftaran Pelamar</h2>

            <form method="POST" action="{{ route('pelamar.store') }}" enctype="multipart/form-data" class="space-y-4">
                @csrf

                {{-- Data pribadi --}}
                <div>
                    <label class="font-medium">Nama Lengkap</label>
                    <input type="text" name="nama_lengkap" value="{{ old('nama_lengkap') }}" class="w-full border rounded-lg p-2">
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <label class="font-medium">Tempat Lahir</label>
                        <input type="text" name="tempat_lahir" value="{{ old('tempat_lahir') }}" class="w-full border rounded-lg p-2">
                    </div>
                    <div>
                        <label class="font-medium">Tanggal Lahir</label>
                        <input type="date" name="tanggal_lahir" value="{{ old('tanggal_lahir') }}" class="w-full border rounded-lg p-2">
                    </div>
                    <div>
                        <label class="font-medium">Umur</label>
                        <input type="number" name="umur" value="{{ old('umur') }}" class="w-full border rounded-lg p-2">
                    </div>
                </div>

                <div>
                    <label class="font-medium">Posisi yang Dilamar</label>
                    <select name="id_job" class="w-full border rounded-lg p-2">
                        <option value="">-- Pilih Posisi --</option>
                        @foreach($jobs as $job)
                        <option value="{{ $job['id_job'] }}"
                            {{ (old('id_job') == $job['id_job'] || (isset($selectedJobId) && $selectedJobId == $job['id_job'])) ? 'selected' : '' }}>
                            {{ $job['posisi'] }}
                        </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="font-medium">No. HP</label>
                    <input type="text" name="no_hp" value="{{ old('no_hp') }}" class="w-full border rounded-lg p-2">
                </div>

                <div>
                    <label class="font-medium">Email</label>
                    <input type="email" name="email" value="{{ old('email') }}" class="w-full border rounded-lg p-2">
                </div>

                <div>
                    <label class="font-medium">Alamat</label>
                    <textarea name="alamat" class="w-full border rounded-lg p-2">{{ old('alamat') }}</textarea>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="font-medium">Pendidikan Terakhir</label>
                        <select name="pendidikan_terakhir" class="w-full border rounded-lg p-2">
                            <option value="">-- Pilih Pendidikan --</option>
                            <option value="SD" {{ old('pendidikan_terakhir') == 'SD' ? 'selected' : '' }}>SD/MI</option>
                            <option value="SMP" {{ old('pendidikan_terakhir') == 'SMP' ? 'selected' : '' }}>SMP</option>
                            <option value="SMA" {{ old('pendidikan_terakhir') == 'SMA' ? 'selected' : '' }}>SMA/SMK/MA</option>
                            <option value="D3" {{ old('pendidikan_terakhir') == 'D3' ? 'selected' : '' }}>D3</option>
                            <option value="S1" {{ old('pendidikan_terakhir') == 'S1' ? 'selected' : '' }}>S1</option>
                        </select>
                    </div>
                    <div>
                        <label class="font-medium">Sekolah / Universitas</label>
                        <input type="text" name="nama_sekolah" value="{{ old('nama_sekolah') }}" class="w-full border rounded-lg p-2">
                    </div>
                </div>

                <div>
                    <label class="font-medium">Pengetahuan Perusahaan</label>
                    <textarea name="pengetahuan_perusahaan" class="w-full border rounded-lg p-2">{{ old('pengetahuan_perusahaan') }}</textarea>
                </div>

                <div>
                    <label class="font-medium">Ekspektasi Gaji</label>
                    <input type="number" name="ekspektasi_gaji" value="{{ old('ekspektasi_gaji') }}" class="w-full border rounded-lg p-2">
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="font-medium">Kelebihan</label>
                        <textarea name="kelebihan" class="w-full border rounded-lg p-2">{{ old('kelebihan') }}</textarea>
                    </div>
                    <div>
                        <label class="font-medium">Kekurangan</label>
                        <textarea name="kekurangan" class="w-full border rounded-lg p-2">{{ old('kekurangan') }}</textarea>
                    </div>
                </div>

                <div>
                    <label class="font-medium">Sosial Media Aktif</label>
                    <input type="text" name="sosial_media" value="{{ old('sosial_media') }}" class="w-full border rounded-lg p-2">
                </div>

                <div>
                    <label class="font-medium">Bersediakah jika ditempatkan di lokasi manapun?</label>
                    <select name="bersedia_lokasi" class="w-full border rounded-lg p-2">
                        <option value="">-- Pilih --</option>
                        <option value="Ya" {{ old('bersedia_lokasi') == 'Ya' ? 'selected' : '' }}>Ya</option>
                        <option value="Tidak" {{ old('bersedia_lokasi') == 'Tidak' ? 'selected' : '' }}>Tidak</option>
                    </select>
                </div>

                <div>
                    <label class="font-medium">Keahlian</label>
                    <textarea name="keahlian" class="w-full border rounded-lg p-2">{{ old('keahlian') }}</textarea>
                </div>

                <div>
                    <label class="font-medium">Apakah Anda yakin bisa meyakinkan kami?</label>
                    <textarea name="yakin_meyakinkan" class="w-full border rounded-lg p-2">{{ old('yakin_meyakinkan') }}</textarea>
                </div>

                <div>
                    <label class="font-medium">Apa Kelebihan Anda dari kandidat lain?</label>
                    <textarea name="kelebihan_dari_kandidat" class="w-full border rounded-lg p-2">{{ old('kelebihan_dari_kandidat') }}</textarea>
                </div>

                <div>
                    <label class="font-medium">Apakah Anda siap bekerja di bawah Target? Mengapa?</label>
                    <textarea name="siap_bekerja_target" class="w-full border rounded-lg p-2">{{ old('siap_bekerja_target') }}</textarea>
                </div>

                <div>
                    <label class="font-medium">Kapan Anda bisa mulai bergabung dengan tim kami?</label>
                    <input type="text" name="kapan_mulai" value="{{ old('kapan_mulai') }}" class="w-full border rounded-lg p-2">
                </div>

                <div>
                    <label class="font-medium">Mengapa Perusahaan harus memberikan gaji sesuai yang Anda harapkan?</label>
                    <textarea name="alasan_gaji" class="w-full border rounded-lg p-2">{{ old('alasan_gaji') }}</textarea>
                </div>

                <div>
                    <label class="font-medium">Upload Berkas</label>
                    <input type="file" name="upload_berkas" class="w-full border rounded-lg p-2">
                </div>

                {{-- Pertanyaan tambahan --}}
                <div>
                    <h3 class="font-bold text-[#072A75] mb-2">Pertanyaan Tambahan</h3>
                    <button type="button" onclick="tambahPertanyaan()" class="bg-green-500 text-white px-3 py-1 rounded-lg mb-3">Tambah Pertanyaan</button>
                    <div id="pertanyaan-container"></div>
                </div>

                {{-- Pengalaman kerja --}}
                <div>
                    <h3 class="font-bold text-[#072A75]">Pengalaman Kerja</h3>
                    <button type="button" onclick="tambahPengalaman()" class="bg-blue-500 text-white px-3 py-1 rounded-lg mb-3">Tambah Pengalaman</button>
                    <div id="pengalaman-container"></div>
                </div>

                <div class="flex justify-between">
                    <button type="submit" class="bg-[#072A75] text-white px-6 py-2 rounded-lg shadow-md">Simpan Perubahan</button>
                    <a href="{{ route('formLamaran.viewPerubahan') }}" class="bg-gray-500 text-white px-6 py-2 rounded-lg shadow-md">View Perubahan</a>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Fungsi tambah pertanyaan baru
        function tambahPertanyaan() {
            let container = document.getElementById('pertanyaan-container');
            let idx = Date.now();
            let div = document.createElement('div');
            div.classList.add("border", "p-4", "rounded-lg", "mb-4", "bg-gray-50");
            div.innerHTML = `
                <div class="flex justify-between items-center mb-2">
                    <input type="text" name="pertanyaan[${idx}][label]" placeholder="Tulis pertanyaan" class="border p-2 rounded-lg w-full">
                    <button type="button" onclick="this.parentElement.parentElement.remove()" class="bg-red-500 text-white px-3 py-1 rounded-lg ml-2">Hapus</button>
                </div>
                <select name="pertanyaan[${idx}][tipe]" class="border p-2 rounded-lg mb-2">
                    <option value="">Pilih Tipe Pertanyaan</option>
                    <option value="text">Teks</option>
                    <option value="textarea">Textarea</option>
                    <option value="radio">Radio</option>
                </select>
            `;
            container.appendChild(div);
        }

        // Fungsi tambah pengalaman
        function tambahPengalaman() {
            let container = document.getElementById('pengalaman-container');
            let idx = Date.now();
            let div = document.createElement('div');
            div.classList.add("border", "p-4", "rounded-lg", "mb-4", "bg-gray-50");
            div.innerHTML = `
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-2">
                    <input type="text" name="pengalaman[${idx}][nama_perusahaan]" placeholder="Nama Perusahaan" class="border p-2 rounded-lg">
                    <input type="text" name="pengalaman[${idx}][posisi]" placeholder="Posisi" class="border p-2 rounded-lg">
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-2">
                    <input type="number" name="pengalaman[${idx}][tahun_mulai]" placeholder="Tahun Masuk" class="border p-2 rounded-lg">
                    <input type="number" name="pengalaman[${idx}][tahun_selesai]" placeholder="Tahun Resign" class="border p-2 rounded-lg">
                </div>
                <textarea name="pengalaman[${idx}][pengalaman]" placeholder="Deskripsi Pekerjaan" class="border p-2 rounded-lg w-full mb-2"></textarea>
                <textarea name="pengalaman[${idx}][alasan_resign]" placeholder="Alasan Resign" class="border p-2 rounded-lg w-full mb-2"></textarea>
                <button type="button" onclick="this.parentElement.remove()" class="bg-red-500 text-white px-3 py-1 rounded-lg">Hapus</button>
            `;
            container.appendChild(div);
        }
    </script>
</body>

</html>
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
        </div>

        {{-- FORM PENDAFTARAN --}}
        <div class="bg-white p-8 rounded-2xl shadow-lg max-h-screen overflow-y-auto">
            <h2 class="text-2xl font-bold text-center text-[#072A75] mb-6">Form Pendaftaran Pelamar</h2>

            <form method="POST" action="{{ route('pelamar.store') }}" enctype="multipart/form-data" class="space-y-4">
                @csrf

                {{-- Data pribadi --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="font-medium">Nama Lengkap</label>
                        <input type="text" name="nama_lengkap" value="{{ old('nama_lengkap') }}" required
                            class="w-full border rounded-lg p-2">
                    </div>
                    <div>
                        <label class="font-medium">No. HP</label>
                        <input type="text" name="no_hp" value="{{ old('no_hp') }}" required
                            class="w-full border rounded-lg p-2">
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <label class="font-medium">Tempat Lahir</label>
                        <input type="text" name="tempat_lahir" value="{{ old('tempat_lahir') }}" required
                            class="w-full border rounded-lg p-2">
                    </div>
                    <div>
                        <label class="font-medium">Tanggal Lahir</label>
                        <input type="date" name="tanggal_lahir" value="{{ old('tanggal_lahir') }}" required
                            class="w-full border rounded-lg p-2">
                    </div>
                    <div>
                        <label class="font-medium">Umur</label>
                        <input type="number" name="umur" value="{{ old('umur') }}" required
                            class="w-full border rounded-lg p-2">
                    </div>
                </div>

                <div>
                    <label class="font-medium">Email</label>
                    <input type="email" name="email" value="{{ old('email') }}" required
                        class="w-full border rounded-lg p-2">
                </div>

                <div>
                    <label class="font-medium">Alamat</label>
                    <textarea name="alamat" required class="w-full border rounded-lg p-2">{{ old('alamat') }}</textarea>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="font-medium">Pendidikan Terakhir</label>
                        <select name="pendidikan_terakhir" required class="w-full border rounded-lg p-2">
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
                        <input type="text" name="nama_sekolah" value="{{ old('nama_sekolah') }}" required
                            class="w-full border rounded-lg p-2">
                    </div>
                </div>

                <div>
                    <label class="font-medium">Posisi yang Dilamar</label>
                    <select name="id_job" required class="w-full border rounded-lg p-2">
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
                    <label class="font-medium">Upload Berkas</label>
                    <input type="file" name="upload_berkas" required class="w-full border rounded-lg p-2">
                </div>

                {{-- Pengalaman kerja --}}
                <div>
                    <h3 class="font-bold text-[#072A75]">Pengalaman Kerja</h3>
                    <button type="button" onclick="tambahPengalaman()"
                        class="bg-blue-500 text-white px-3 py-1 rounded-lg mb-3">+ Tambah Pengalaman</button>
                    <div id="pengalaman-container"></div>
                </div>

                <div class="text-right">
                    <button type="submit" class="bg-[#072A75] text-white px-6 py-2 rounded-lg shadow-md">Submit</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function tambahPengalaman() {
            let container = document.getElementById('pengalaman-container');
            let idx = Date.now();
            let div = document.createElement('div');
            div.classList.add("border", "p-4", "rounded-lg", "mb-4", "bg-gray-50");
            div.innerHTML = `
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-2">
                    <input type="text" name="pengalaman[${idx}][nama_perusahaan]" placeholder="Nama Perusahaan" class="border p-2 rounded-lg" required>
                    <input type="text" name="pengalaman[${idx}][posisi]" placeholder="Posisi" class="border p-2 rounded-lg" required>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-2">
                    <input type="number" name="pengalaman[${idx}][tahun_mulai]" placeholder="Tahun Masuk" class="border p-2 rounded-lg" required>
                    <input type="number" name="pengalaman[${idx}][tahun_selesai]" placeholder="Tahun Resign" class="border p-2 rounded-lg" required>
                </div>
                <textarea name="pengalaman[${idx}][pengalaman]" placeholder="Deskripsi Pekerjaan" class="border p-2 rounded-lg w-full mb-2" required></textarea>
                <textarea name="pengalaman[${idx}][alasan_resign]" placeholder="Alasan Resign" class="border p-2 rounded-lg w-full mb-2" required></textarea>
                <button type="button" onclick="this.parentElement.remove()" class="bg-red-500 text-white px-3 py-1 rounded-lg">Hapus</button>
            `;
            container.appendChild(div);
        }
    </script>
</body>
</html>

<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Form Lamaran - Admin</title>
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

        /* Aturan CSS baru untuk membuat kotak yang bisa digulir */
        .form-scroll-container {
            max-height: 70vh;
            /* Sesuaikan tinggi sesuai kebutuhan, 70vh artinya 70% dari tinggi viewport */
            overflow-y: auto;
            /* Memungkinkan gulir vertikal jika konten melebihi tinggi */
            padding-right: 1rem;
            /* Memberikan sedikit ruang di kanan agar scrollbar tidak menempel */
        }
    </style>
</head>

<body class="bg-gray-200">
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

    <div class="container mx-auto p-8">
        <div class="flex justify-center space-x-4 mb-8">
            <a href="{{ route('admin.jobs.list') }}" class="bg-purple-300 text-white font-semibold py-2 px-6 rounded-lg shadow-lg hover-effect-btn">List Job</a>
            <a href="{{ route('admin.pelamar.list') }}" class="bg-purple-300 text-white font-semibold py-2 px-6 rounded-lg shadow-lg hover-effect-btn">Data Pelamar</a>
            <a href="{{ route('admin.form.lamaran') }}" class="bg-purple-300 text-white font-semibold py-2 px-6 rounded-lg shadow-lg hover-effect-btn">Edit Form Daftar</a>
        </div>

        @if (session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4">{{ session('success') }}</div>
        @endif
        @if (session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4">{{ session('error') }}</div>
        @endif

        <div class="bg-white rounded-2xl shadow-xl p-8 mb-8">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-2xl font-bold text-gray-800">Form Lamaran Kerja</h2>
                <button type="button" class="bg-blue-500 text-white font-semibold py-2 px-4 rounded-lg shadow hover:bg-blue-600">Edit Form</button>
            </div>

            <div class="form-scroll-container">
                <form action="{{ route('admin.form.lamaran.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-gray-700 font-medium mb-2">Nama Lengkap</label>
                            <input type="text" name="nama_lengkap" value="{{ old('nama_lengkap') }}" class="w-full border rounded-lg px-4 py-2">
                        </div>
                        <div>
                            <label class="block text-gray-700 font-medium mb-2">Tempat Lahir</label>
                            <input type="text" name="tempat_lahir" value="{{ old('tempat_lahir') }}" class="w-full border rounded-lg px-4 py-2">
                        </div>
                        <div>
                            <label class="block text-gray-700 font-medium mb-2">Tanggal Lahir</label>
                            <input type="date" name="tanggal_lahir" value="{{ old('tanggal_lahir') }}" class="w-full border rounded-lg px-4 py-2">
                        </div>
                        <div>
                            <label class="block text-gray-700 font-medium mb-2">Umur</label>
                            <input type="number" name="umur" value="{{ old('umur') }}" class="w-full border rounded-lg px-4 py-2">
                        </div>
                        <div>
                            <label class="block text-gray-700 font-medium mb-2">No. HP</label>
                            <input type="text" name="no_hp" value="{{ old('no_hp') }}" class="w-full border rounded-lg px-4 py-2">
                        </div>
                        <div>
                            <label class="block text-gray-700 font-medium mb-2">Email</label>
                            <input type="email" name="email" value="{{ old('email') }}" class="w-full border rounded-lg px-4 py-2">
                        </div>
                        <div>
                            <label class="block text-gray-700 font-medium mb-2">Pendidikan Terakhir</label>
                            <input type="text" name="pendidikan_terakhir" value="{{ old('pendidikan_terakhir') }}" class="w-full border rounded-lg px-4 py-2">
                        </div>
                        <div>
                            <label class="block text-gray-700 font-medium mb-2">Nama Sekolah</label>
                            <input type="text" name="nama_sekolah" value="{{ old('nama_sekolah') }}" class="w-full border rounded-lg px-4 py-2">
                        </div>
                        <div>
                            <label class="block text-gray-700 font-medium mb-2">Jurusan</label>
                            <input type="text" name="jurusan" value="{{ old('jurusan') }}" class="w-full border rounded-lg px-4 py-2">
                        </div>
                        <div>
                            <label class="block text-gray-700 font-medium mb-2">Posisi yang Dilamar</label>
                            <select name="job_id" class="w-full border rounded-lg px-4 py-2">
                                <option value="">-- Pilih Posisi --</option>
                                @foreach($jobs as $job)
                                <option value="{{ $job['id_job'] ?? '' }}">{{ $job['posisi'] ?? '' }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-gray-700 font-medium mb-2">Upload CV</label>
                            <input type="file" name="cv" class="w-full border rounded-lg px-4 py-2">
                        </div>
                        <div>
                            <label class="block text-gray-700 font-medium mb-2">Upload Foto</label>
                            <input type="file" name="foto" class="w-full border rounded-lg px-4 py-2">
                        </div>
                        <div>
                            <label class="block text-gray-700 font-medium mb-2">Bersedia Ditempatkan di Cilacap?</label>
                            <select name="bersedia_cilacap" class="w-full border rounded-lg px-4 py-2">
                                <option value="" {{ old('bersedia_cilacap') == ''? 'selected' : '' }} disabled hidden>Pilih</option>
                                <option value="bersedia" {{ old('bersedia_cilacap') == 'bersedia' ? 'selected' : '' }}>Bersedia</option>
                                <option value="tidak bersedia" {{ old('bersedia_cilacap') == 'tidak bersedia' ? 'selected' : '' }}>Tidak Bersedia</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-gray-700 font-medium mb-2">Kapan Bisa Gabung?</label>
                            <input type="text" name="kapan_bisa_gabung" value="{{ old('kapan_bisa_gabung') }}" class="w-full border rounded-lg px-4 py-2">
                        </div>
                        <div>
                            <label class="block text-gray-700 font-medium mb-2">Ekspektasi Gaji</label>
                            <input type="text" name="ekspektasi_gaji" value="{{ old('ekspektasi_gaji') }}" class="w-full border rounded-lg px-4 py-2">
                        </div>
                    </div>

                    <div class="mt-6">
                        <label class="block text-gray-700 font-medium mb-2">Alamat Lengkap</label>
                        <textarea name="alamat" rows="3" class="w-full border rounded-lg px-4 py-2">{{ old('alamat') }}</textarea>
                    </div>
                    <div class="mt-6">
                        <label class="block text-gray-700 font-medium mb-2">Pengetahuan tentang Perusahaan</label>
                        <textarea name="pengetahuan_perusahaan" rows="3" class="w-full border rounded-lg px-4 py-2">{{ old('pengetahuan_perusahaan') }}</textarea>
                    </div>
                    <div class="mt-6">
                        <label class="block text-gray-700 font-medium mb-2">Keahlian (Skill)</label>
                        <textarea name="keahlian" rows="3" class="w-full border rounded-lg px-4 py-2">{{ old('keahlian') }}</textarea>
                    </div>
                    <div class="mt-6">
                        <label class="block text-gray-700 font-medium mb-2">Tujuan Mendaftar di Perusahaan</label>
                        <textarea name="tujuan_daftar" rows="3" class="w-full border rounded-lg px-4 py-2">{{ old('tujuan_daftar') }}</textarea>
                    </div>
                    <div class="mt-6">
                        <label class="block text-gray-700 font-medium mb-2">Kelebihan Diri</label>
                        <textarea name="kelebihan" rows="3" class="w-full border rounded-lg px-4 py-2">{{ old('kelebihan') }}</textarea>
                    </div>
                    <div class="mt-6">
                        <label class="block text-gray-700 font-medium mb-2">Kekurangan Diri</label>
                        <textarea name="kekurangan" rows="3" class="w-full border rounded-lg px-4 py-2">{{ old('kekurangan') }}</textarea>
                    </div>
                    <div class="mt-6">
                        <label class="block text-gray-700 font-medium mb-2">Menurut Anda, mengapa kami harus merekrut Anda?</label>
                        <textarea name="alasan_merekrut" rows="3" class="w-full border rounded-lg px-4 py-2">{{ old('alasan_merekrut') }}</textarea>
                    </div>
                    <div class="mt-6">
                        <label class="block text-gray-700 font-medium mb-2">Apa kelebihan Anda dibanding kandidat lain?</label>
                        <textarea name="kelebihan_dari_yang_lain" rows="3" class="w-full border rounded-lg px-4 py-2">{{ old('kelebihan_dari_yang_lain') }}</textarea>
                    </div>
                    <div class="mt-6">
                        <label class="block text-gray-700 font-medium mb-2">Bagaimana cara Anda bekerja di bawah tekanan?</label>
                        <textarea name="alasan_bekerja_dibawah_tekanan" rows="3" class="w-full border rounded-lg px-4 py-2">{{ old('alasan_bekerja_dibawah_tekanan') }}</textarea>
                    </div>
                    <div class="mt-6">
                        <label class="block text-gray-700 font-medium mb-2">Alasan mengajukan ekspektasi gaji tersebut</label>
                        <textarea name="alasan_ekspektasi" rows="3" class="w-full border rounded-lg px-4 py-2">{{ old('alasan_ekspektasi') }}</textarea>
                    </div>

                    <div class="flex justify-between mt-8">
                        <a href="#" class="bg-green-500 text-white font-semibold py-2 px-6 rounded-lg shadow-lg hover:bg-green-600">View Perubahan Form</a>

                        <button type="submit" class="bg-blue-500 text-white font-semibold py-2 px-6 rounded-lg shadow-lg hover:bg-blue-600">Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
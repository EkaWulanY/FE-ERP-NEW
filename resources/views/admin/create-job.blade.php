<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Lowongan Baru - Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap');

        body {
            font-family: 'Inter', sans-serif;
            background-color: #e5e7eb;
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
                <path stroke-linecap="round" stroke-linejoin="round" d="M5.121 17.804A7.962 7.962 0 0112 15a7.962 7.962 0 016.879 2.804M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
            </svg>
        </div>
    </div>
    <div class="container mx-auto p-4 md:p-8">
        <div class="bg-white rounded-2xl shadow-xl p-6 md:p-8">
            <h2 class="text-2xl font-bold text-gray-800 mb-6">Tambah Lowongan Baru</h2>
            @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
            @endif
            @if (session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                <span class="block sm:inline">{{ session('error') }}</span>
            </div>
            @endif
            @if ($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                <ul class="list-disc list-inside text-sm">
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif
            <form action="{{ isset($job) ? route('admin.jobs.update', $job['id_job']) : route('admin.jobs.store') }}" method="POST">
                @csrf
                @if(isset($job))
                @method('PUT')
                @endif
                <div class="mb-4">
                    <label for="posisi" class="block text-gray-700 text-sm font-bold mb-2">Posisi:</label>
                    <input type="text" name="posisi" id="posisi"
                        class="shadow appearance-none border rounded w-full py-2 px-3 leading-tight focus:outline-none focus:shadow-outline"
                        value="{{ old('posisi', $job['posisi'] ?? '') }}" required>
                </div>

                <div class="mb-4">
                    <label for="deskripsi" class="block text-gray-700 text-sm font-bold mb-2">Deskripsi Singkat:</label>
                    <textarea name="deskripsi" id="deskripsi" rows="3"
                        class="shadow appearance-none border rounded w-full py-2 px-3 leading-tight focus:outline-none focus:shadow-outline"
                        required>{{ old('deskripsi', $job['deskripsi'] ?? '') }}</textarea>
                </div>
                <div class="mb-4">
                    <label for="jobdesk" class="block text-gray-700 text-sm font-bold mb-2">Deskripsi Pekerjaan:</label>
                    <textarea name="jobdesk" id="jobdesk" rows="3"
                        class="shadow appearance-none border rounded w-full py-2 px-3 leading-tight focus:outline-none focus:shadow-outline"
                        required>{{ old('jobdesk', $job['jobdesk'] ?? '') }}</textarea>
                </div>

                <div class="mb-4">
                    <label for="kualifikasi" class="block text-gray-700 text-sm font-bold mb-2">Kualifikasi:</label>
                    <textarea name="kualifikasi" id="kualifikasi" rows="3"
                        class="shadow appearance-none border rounded w-full py-2 px-3 leading-tight focus:outline-none focus:shadow-outline"
                        required>{{ old('kualifikasi', $job['kualifikasi'] ?? '') }}</textarea>
                </div>

                <div class="mb-4">
                    <label for="lokasi" class="block text-gray-700 text-sm font-bold mb-2">Lokasi:</label>
                    <input type="text" name="lokasi" id="lokasi"
                        class="shadow appearance-none border rounded w-full py-2 px-3 leading-tight focus:outline-none focus:shadow-outline"
                        value="{{ old('lokasi', $job['lokasi'] ?? '') }}" required>
                </div>

                <div class="mb-4">
                    <label for="tanggal_post" class="block text-gray-700 text-sm font-bold mb-2">Tanggal Posting:</label>
                    <input type="date" name="tanggal_post" id="tanggal_post"
                        class="shadow appearance-none border rounded w-full py-2 px-3 leading-tight focus:outline-none focus:shadow-outline"
                        value="{{ old('tanggal_post', $job['tanggal_post'] ?? now()->toDateString()) }}" required>
                </div>

                <div class="mb-4">
                    <label for="status" class="block text-gray-700 text-sm font-bold mb-2">Status:</label>
                    <select name="status" id="status"
                        class="shadow border rounded w-full py-2 px-3 leading-tight focus:outline-none focus:shadow-outline"
                        required>
                        <option value="aktif" {{ old('status', $job['status'] ?? '') == 'aktif' ? 'selected' : '' }}>Aktif</option>
                        <option value="nonaktif" {{ old('status', $job['status'] ?? '') == 'nonaktif' ? 'selected' : '' }}>Nonaktif</option>
                    </select>
                </div>

                <input type="hidden" name="pendidikan_min" value="">
                <input type="hidden" name="image_url" value="">
                <input type="hidden" name="batas_lamaran" value="">
                <div class="flex items-center justify-between mt-6">
                    <button type="submit" class="bg-green-500 text-white font-bold py-2 px-4 rounded-lg hover:bg-green-600 transition-colors">
                        {{ isset($job) ? 'Update Lowongan' : 'Simpan Lowongan' }}
                    </button>
                    <a href="{{ route('admin.jobs.list') }}" class="text-blue-500 hover:text-blue-800">
                        Batal
                    </a>
                </div>
            </form>

        </div>

    </div>
</body>

</html>
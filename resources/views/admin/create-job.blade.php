<!DOCTYPE html>
<html lang="en">

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

        .hover-effect-btn:hover {
            background-color: #4E71FF;
            transition: background-color 0.3s ease;
        }
    </style>
</head>

<body class="bg-gray-200">
    <!-- Header -->
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

    <!-- Main Content -->
    <div class="container mx-auto p-8">
        <div class="bg-white rounded-2xl shadow-xl p-8 mb-8">
            <h2 class="text-2xl font-bold text-gray-800 mb-6">Tambah Lowongan Baru</h2>

            <!-- Pesan Sukses -->
            @if (session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4"
                    role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            <!-- Pesan Error -->
            @if (session('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4"
                    role="alert">
                    <span class="block sm:inline">{{ session('error') }}</span>
                </div>
            @endif

            <!-- Validasi Error -->
            @if ($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                    <ul class="list-disc list-inside text-sm">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Form -->
            <form action="{{ route('admin.jobs.store') }}" method="POST">
                @csrf

                <!-- Posisi -->
                <div class="mb-4">
                    <label for="posisi" class="block text-gray-700 text-sm font-bold mb-2">Posisi:</label>
                    <input type="text" name="posisi" id="posisi"
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight 
                        focus:outline-none focus:shadow-outline @error('posisi') border-red-500 @enderror"
                        value="{{ old('posisi') }}" required>
                    @error('posisi')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Deskripsi Job -->
                <div class="mb-4">
                    <label for="deskripsi_job" class="block text-gray-700 text-sm font-bold mb-2">Deskripsi Job:</label>
                    <textarea name="deskripsi_job" id="deskripsi_job" rows="5"
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight 
                        focus:outline-none focus:shadow-outline @error('deskripsi_job') border-red-500 @enderror"
                        required>{{ old('deskripsi_job') }}</textarea>
                    @error('deskripsi_job')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Tombol -->
                <div class="flex items-center justify-between mt-6">
                    <button type="submit"
                        class="bg-green-500 text-white font-bold py-2 px-4 rounded-lg shadow-md 
                        hover:bg-green-600 focus:outline-none focus:shadow-outline">
                        Simpan Lowongan
                    </button>
                    <a href="{{ route('admin.jobs.list') }}"
                        class="inline-block align-baseline font-bold text-sm text-blue-500 hover:text-blue-800">
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
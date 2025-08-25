<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>List Job - Admin</title>
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
            <a href="{{ route('admin.jobs.list') }}"
                class="bg-purple-300 text-white font-semibold py-2 px-6 rounded-lg shadow-lg hover-effect-btn">List
                Job</a>
            <a href="{{ route('admin.pelamar.list') }}"
                class="bg-purple-300 text-white font-semibold py-2 px-6 rounded-lg shadow-lg hover-effect-btn">Data
                Pelamar</a>
            <a href="{{ route('admin.form.lamaran') }}"
                class="bg-purple-300 text-white font-semibold py-2 px-6 rounded-lg shadow-lg hover-effect-btn">Edit Form
                Daftar</a>
        </div>
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
        <div class="bg-white rounded-2xl shadow-xl p-8 mb-8">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-2xl font-bold text-gray-800">Semua Lowongan</h2>
                <a href="{{ route('admin.jobs.create') }}"
                    class="bg-blue-500 text-white font-semibold py-2 px-4 rounded-lg shadow-lg hover:bg-blue-600 transition-colors text-sm">Tambah
                    Baru</a>
            </div>

            <div class="overflow-x-auto max-h-96 overflow-y-auto">
                <table class="min-w-full divide-y divide-gray-200 table-fixed">
                    <thead class="bg-gray-50 sticky top-0">
                        <tr>
                            <th scope="col"
                                class="w-1/2 px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Posisi</th>
                            <th scope="col"
                                class="w-1/4 px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Status</th>
                            <th scope="col"
                                class="w-1/4 px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        {{-- Perbaikan: Mengganti variabel dari $allJobs menjadi $jobs --}}
                        @foreach ($jobs as $job)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                {{ $job['posisi']?? 'N/A' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if (!empty($job['status']) && $job['status'] === 'aktif')
                                <span
                                    class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                    Aktif
                                </span>
                                @else
                                <span
                                    class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                    Non-aktif
                                </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium flex items-center space-x-2">
                                @if (!empty($job['status']) && $job['status'] === 'aktif')
                                <form action="{{ route('admin.jobs.deactivate', $job['id_job']) }}" method="POST"
                                    class="inline">
                                    @csrf
                                    @method('PUT')
                                    <button type="submit"
                                        class="text-red-600 hover:text-red-900 p-1 rounded-md">Non-aktifkan</button>
                                </form>
                                @else
                                <form action="{{ route('admin.jobs.activate', $job['id_job']) }}" method="POST"
                                    class="inline">
                                    @csrf
                                    @method('PUT')
                                    <button type="submit"
                                        class="text-green-600 hover:text-green-900 p-1 rounded-md">Aktifkan</button>
                                </form>
                                @endif

                                <form action="{{ route('admin.jobs.delete', $job['id_job']) }}" method="POST"
                                    class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus lowongan ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="text-red-600 hover:text-red-900 p-1 rounded-md">Hapus</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="fixed bottom-8 left-8">
        <a href="{{ route('admin.dashboard') }}"
            class="bg-gray-400 text-white py-2 px-4 rounded-lg shadow-lg hover:bg-red-500 transition-colors text-sm">
            Kembali
        </a>
    </div>
</body>
</html>
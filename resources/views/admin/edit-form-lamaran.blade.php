<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pengaturan Form Pendaftaran - Admin</title>
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

        .modal {
            transition: opacity 0.3s ease-in-out;
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
            <svg class="h-8 w-8 rounded-full border-2 border-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M5.121 17.804A7.962 7.962 0 0112 15a7.962 7.962 0 016.879 2.804M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
            </svg>
        </div>
    </div>
    <div class="container mx-auto p-8">
        <div class="flex justify-center space-x-4 mb-8">
            <a href="{{ route('admin.jobs.list') }}" class="bg-purple-300 text-white font-semibold py-2 px-6 rounded-lg shadow-lg hover-effect-btn">List Job</a>
            <a href="{{ route('admin.pelamar.list') }}" class="bg-purple-300 text-white font-semibold py-2 px-6 rounded-lg shadow-lg hover-effect-btn">Data Pelamar</a>
            <a href="{{ route('admin.form.edit') }}" class="bg-blue-600 text-white font-semibold py-2 px-6 rounded-lg shadow-lg hover-effect-btn">Edit Form Daftar</a>
        </div>
        @if (session('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4" role="alert">
            <p>{{ session('success') }}</p>
        </div>
        @endif
        @if (session('error'))
        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4" role="alert">
            <p>{{ session('error') }}</p>
        </div>
        @endif
        <div class="bg-white rounded-2xl shadow-xl p-8 mb-8">
            <h2 class="text-2xl font-bold text-gray-800 mb-6">Pengaturan Form Pendaftaran</h2>
            <form action="#" method="POST">
                @csrf
                <div class="mb-6">
                    <label class="block text-gray-700 font-medium mb-2">Pilih Posisi</label>
                    <select name="job_id" class="w-full border rounded-lg px-4 py-2">
                        <option value="">-- Pilih Posisi --</option>
                        @foreach($jobs as $job)
                        <option value="{{ $job->id_job }}">{{ $job->posisi }}</option>
                        @endforeach
                    </select>
                </div>
            </form>
            <h3 class="text-lg font-bold text-gray-800 mb-4">Pertanyaan Tambahan</h3>
            <div class="space-y-4 mb-6">
                @forelse($pertanyaan as $item)
                <div class="flex items-center justify-between p-4 bg-gray-100 rounded-lg">
                    <p class="text-gray-700">{{ $item->pertanyaan }}</p>
                    <div class="flex items-center space-x-2">
                        <button type="button" class="edit-pertanyaan-btn text-gray-500 hover:text-blue-500"
                            data-id="{{ $item->id }}" data-pertanyaan="{{ $item->pertanyaan }}">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                            </svg>
                        </button>
                        <form action="{{ route('admin.form.pertanyaan.delete', $item->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus pertanyaan ini?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-gray-500 hover:text-red-500">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                </svg>
                            </button>
                        </form>
                    </div>
                </div>
                @empty
                <p class="text-gray-500">Belum ada pertanyaan tambahan.</p>
                @endforelse
            </div>
            <button type="button" id="tambah-pertanyaan-btn" class="flex items-center text-blue-600 hover:text-blue-800 font-semibold mb-8">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd" />
                </svg>
                Tambah Pertanyaan
            </button>
            <div class="flex justify-end">
                <button type="button" class="bg-blue-500 text-white font-semibold py-2 px-6 rounded-lg shadow-lg hover:bg-blue-600">Simpan Perubahan</button>
            </div>
        </div>
    </div>
    <div id="modal-container" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden items-center justify-center">
        <div class="bg-white p-6 rounded-lg shadow-xl w-1/3">
            <h3 id="modal-title" class="text-xl font-bold mb-4">Edit Pertanyaan</h3>
            <form id="pertanyaan-form" method="POST">
                @csrf
                <input type="hidden" name="_method" id="form-method">
                <input type="hidden" name="id" id="pertanyaan-id">
                <div class="mb-4">
                    <label for="pertanyaan-input" class="block text-gray-700 font-medium mb-2">Isi Pertanyaan</label>
                    <input type="text" id="pertanyaan-input" name="pertanyaan" class="w-full border rounded-lg px-4 py-2" required>
                </div>
                <div class="flex justify-end space-x-2">
                    <button type="button" id="cancel-btn" class="bg-gray-300 text-gray-800 py-2 px-4 rounded-lg">Batal</button>
                    <button type="submit" class="bg-blue-500 text-white py-2 px-4 rounded-lg">Simpan</button>
                </div>
            </form>
        </div>
    </div>
    <script>
        const modalContainer = document.getElementById('modal-container');
        const modalTitle = document.getElementById('modal-title');
        const pertanyaanForm = document.getElementById('pertanyaan-form');
        const pertanyaanInput = document.getElementById('pertanyaan-input');
        const pertanyaanId = document.getElementById('pertanyaan-id');
        const formMethod = document.getElementById('form-method');

        document.querySelectorAll('.edit-pertanyaan-btn').forEach(button => {
            button.addEventListener('click', function() {
                const id = this.dataset.id;
                const pertanyaan = this.dataset.pertanyaan;
                modalTitle.innerText = 'Edit Pertanyaan';
                pertanyaanInput.value = pertanyaan;
                pertanyaanForm.action = `{{ url('/form/pertanyaan') }}/${id}`;
                pertanyaanId.value = id;
                formMethod.value = 'PUT';
                modalContainer.classList.remove('hidden');
            });
        });

        document.getElementById('tambah-pertanyaan-btn').addEventListener('click', function() {
            modalTitle.innerText = 'Tambah Pertanyaan';
            pertanyaanInput.value = '';
            pertanyaanForm.action = `{{ route('admin.form.pertanyaan.store') }}`;
            pertanyaanId.value = '';
            formMethod.value = '';
            modalContainer.classList.remove('hidden');
        });

        document.getElementById('cancel-btn').addEventListener('click', function() {
            modalContainer.classList.add('hidden');
        });
    </script>
</body>

</html>
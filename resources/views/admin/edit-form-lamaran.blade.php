<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pengaturan Form Pendaftaran Admin</title>
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

        .form-scroll-container {
            max-height: 70vh;
            overflow-y: auto;
            padding-right: 0.5rem;
        }

        .form-scroll-container::-webkit-scrollbar {
            width: 8px;
        }

        .form-scroll-container::-webkit-scrollbar-thumb {
            background-color: #9ca3af;
            border-radius: 4px;
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

    <div class="container mx-auto p-6">
        <div class="flex justify-center space-x-4 mb-6">
            <a href="{{ route('admin.jobs.list') }}"
                class="bg-purple-300 text-white font-semibold py-2 px-6 rounded-lg shadow-lg hover-effect-btn">List Job</a>
            <a href="{{ route('admin.pelamar.list') }}"
                class="bg-purple-300 text-white font-semibold py-2 px-6 rounded-lg shadow-lg hover-effect-btn">Data Pelamar</a>
            <a href="{{ route('admin.form.edit') }}"
                class="bg-purple-300 text-white font-semibold py-2 px-6 rounded-lg shadow-lg hover-effect-btn">Edit Form Daftar</a>
        </div>

        <div class="bg-white rounded-2xl shadow-xl mx-auto p-8 w-full max-w-5xl">
            <h2 class="text-2xl font-bold text-gray-800 mb-6">Pengaturan Form Pendaftaran</h2>

            <div class="mb-6 border-b border-gray-200 pb-4">
                <h3 class="text-xl font-semibold text-gray-800 mb-4">Tambah Pertanyaan Baru</h3>
                <form id="add-pertanyaan-form" method="POST" action="{{ route('admin.form.pertanyaan.store') }}">
                    @csrf
                    <div class="mb-4">
                        <label for="id_job" class="block text-sm font-medium text-gray-700">Pilih Posisi</label>
                        <select id="id_job" name="id_job" required
                            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm p-2">
                            <option value="">-- Pilih Posisi --</option>
                            @foreach($jobs as $job)
                                <option value="{{ $job['id_job'] }}">{{ $job['posisi'] }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-4">
                        <label for="label" class="block text-sm font-medium text-gray-700">Pertanyaan</label>
                        <textarea id="label" name="label" rows="3" required
                            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm p-2"></textarea>
                    </div>

                    <button type="submit"
                        class="bg-blue-500 text-white font-semibold py-2 px-4 rounded-lg shadow-lg hover:bg-blue-600">
                        Simpan Pertanyaan
                    </button>
                </form>
            </div>

            <div>
                <h3 class="text-xl font-semibold text-gray-800 mb-4">Daftar Pertanyaan Tambahan</h3>
                <div class="space-y-4 mb-6 form-scroll-container border border-gray-200 rounded-lg bg-gray-50 p-4">
                    @forelse($formFields as $field)
                        <div class="flex items-center justify-between p-4 bg-white rounded-lg shadow">
                            <p class="text-gray-700">[{{ $field->job?->posisi }}] {{ $field->label }}</p>
                            <div class="flex items-center space-x-2">
                                <button type="button" class="edit-pertanyaan-btn text-gray-500 hover:text-blue-500"
                                    data-id="{{ $field->id_field_job }}" data-label="{{ $field->label }}">
                                    ✏️
                                </button>
                                <form action="{{ route('admin.form.pertanyaan.delete', $field->id_field_job) }}" method="POST"
                                    onsubmit="return confirm('Apakah Anda yakin ingin menghapus pertanyaan ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-gray-500 hover:text-red-500">🗑️</button>
                                </form>
                            </div>
                        </div>
                    @empty
                        <p class="text-gray-500 text-center py-4">Belum ada pertanyaan tambahan.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    <div id="edit-modal" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50 hidden">
        <div class="bg-white rounded-lg shadow-xl p-6 w-full max-w-md mx-4">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-xl font-bold">Edit Pertanyaan</h3>
                <button type="button" class="text-gray-400 hover:text-gray-600" id="close-edit-modal-btn">
                    <span class="sr-only">Close modal</span>
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            <form id="edit-pertanyaan-form" method="POST">
                @csrf
                @method('PUT')
                <div class="mb-4">
                    <label for="edit-label" class="block text-sm font-medium text-gray-700">Pertanyaan</label>
                    <textarea id="edit-label" name="label" rows="3" required
                        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm p-2"></textarea>
                </div>
                <div class="flex justify-end">
                    <button type="submit"
                        class="bg-blue-500 text-white font-semibold py-2 px-4 rounded-lg shadow-lg hover:bg-blue-600">
                        Perbarui
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const editModal = document.getElementById('edit-modal');
            const closeEditModalBtn = document.getElementById('close-edit-modal-btn');
            const editButtons = document.querySelectorAll('.edit-pertanyaan-btn');
            const editForm = document.getElementById('edit-pertanyaan-form');
            const editLabelInput = document.getElementById('edit-label');

            editButtons.forEach(button => {
                button.addEventListener('click', (e) => {
                    const id = e.currentTarget.dataset.id;
                    const label = e.currentTarget.dataset.label;
                    
                    // Correctly set the form action to the update route with the ID
                    editForm.action = `/admin/form/pertanyaan/${id}/update`;
                    editLabelInput.value = label;
                    editModal.classList.remove('hidden');
                });
            });

            closeEditModalBtn.addEventListener('click', () => {
                editModal.classList.add('hidden');
            });

            editModal.addEventListener('click', (e) => {
                if (e.target === editModal) {
                    editModal.classList.add('hidden');
                }
            });
        });
    </script>
</body>
</html>
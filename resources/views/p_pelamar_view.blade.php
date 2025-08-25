<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Pelamar</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap');
        body { font-family: 'Inter', sans-serif; background-color: #e5e7eb; }
        .hover-effect-btn:hover {
            background-color: #4E71FF;
            transition: background-color 0.3s ease;
        }
        /* Style untuk Modal */
        .modal {
            display: none; /* Hidden by default */
            position: fixed; /* Stay in place */
            z-index: 1000; /* Sit on top */
            left: 0;
            top: 0;
            width: 100%; /* Full width */
            height: 100%; /* Full height */
            overflow: auto; /* Enable scroll if needed */
            background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
            justify-content: center;
            align-items: center;
        }
        .modal-content {
            background-color: #fefefe;
            margin: auto;
            padding: 24px;
            border-radius: 8px;
            width: 90%;
            max-width: 700px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body class="bg-gray-200">
    <div class="bg-[#072A75] text-white p-4 flex justify-between items-center shadow-lg">
        <div class="flex items-center">
            <img src="{{ asset('admin/img/logo.jpg') }}" alt="Logo" class="h-8 w-8 mr-2 rounded-full">
            <span class="text-xl font-bold">XMLTRONIK-KARIR</span>
        </div>
        <div class="flex items-center">
            <span class="mr-2">Pelamar</span>
            <svg class="h-8 w-8 rounded-full border-2 border-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M5.121 17.804A7.962 7.962 0 0112 15a7.962 7.962 0 016.879 2.804M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
            </svg>
        </div>
    </div>

    <main class="container mx-auto px-4 py-8">
        <section class="bg-white p-6 rounded-xl my-8 shadow-lg">
            <div class="flex items-center space-x-4">
                <div class="relative w-full">
                    <input type="text" id="keywords" placeholder="Keywords" class="w-full p-2 pl-10 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/></svg>
                </div>
                <button onclick="searchJobs()" class="bg-indigo-600 text-white p-2 rounded-lg btn-hover flex-shrink-0 flex items-center space-x-1">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-search"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/></svg>
                    <span>Search</span>
                </button>
            </div>
            <div class="flex flex-wrap items-center mt-4 space-x-4">
                <select id="education-filter" class="p-2 border rounded-lg w-full md:w-auto mt-2 md:mt-0">
                    <option value="">Pendidikan</option>
                    <option value="SMK">SMK</option>
                    <option value="D3">D3</option>
                    <option value="D4">D4</option>
                    <option value="S1">S1</option>
                    <option value="S2">S2</option>
                    <option value="S3">S3</option>
                </select>
                <select id="job-type-filter" class="p-2 border rounded-lg w-full md:w-auto mt-2 md:mt-0">
                    <option value="">Job Type</option>
                    @foreach ($jobs as $job)
                        <option value="{{ $job->posisi }}">{{ $job->posisi }}</option>
                    @endforeach
                </select>
                <select id="location-filter" class="p-2 border rounded-lg w-full md:w-auto mt-2 md:mt-0">
                    <option value="">Lokasi</option>
                    <option value="Cilacap">Cilacap</option>
                    <option value="Banyumas">Banyumas</option>
                    <option value="Tegal">Tegal</option>
                    <option value="Purbalingga">Purbalingga</option>
                </select>
            </div>
        </section>

        <section id="job-listings" class="space-y-6">
            </section>

    </main>

    <div id="job-detail-modal" class="modal">
        <div class="modal-content shadow-lg">
            <div class="flex justify-between items-start">
                <h2 class="text-2xl font-bold text-gray-800" id="modal-job-title"></h2>
                <button onclick="closeModal()" class="text-gray-500 hover:text-gray-700 text-2xl font-bold">&times;</button>
            </div>
            <div id="modal-job-content" class="mt-4 text-gray-700">
                </div>
            <div class="mt-6 flex justify-end">
                <button onclick="closeModal()" class="bg-gray-300 text-gray-800 px-6 py-2 rounded-lg font-semibold mr-2 btn-hover">Tutup</button>
                <button onclick="applyJob()" class="bg-orange-500 text-white px-6 py-2 rounded-lg font-semibold btn-hover">Lamar Sekarang</button>
            </div>
        </div>
    </div>
    
    <script>
        // JavaScript section, now directly inside the Blade file
        document.addEventListener('DOMContentLoaded', () => {
            fetchActiveJobs();
        });

        // Hati-hati: localhost tidak dapat diakses dari lingkungan ini.
        // Ganti URL di bawah ini dengan URL API yang dapat diakses secara publik (misalnya, IP server, atau domain).
        // const API_URL = 'http://localhost:8080/api';
        const API_URL = 'http://127.0.0.1:8080/api'; // Menggunakan IP loopback yang lebih umum.

        async function fetchActiveJobs() {
            try {
                const response = await fetch(`${API_URL}/jobs/aktif`);
                if (!response.ok) {
                    throw new Error('Gagal memuat lowongan kerja.');
                }
                const data = await response.json();
                renderJobs(data);
            } catch (error) {
                console.error('Error fetching jobs:', error);
                document.getElementById('job-listings').innerHTML = '<p class="text-center text-red-500">Gagal memuat lowongan kerja. Silakan coba lagi nanti.</p>';
            }
        }

        function renderJobs(jobs) {
            const container = document.getElementById('job-listings');
            container.innerHTML = '';

            if (jobs.length === 0) {
                container.innerHTML = '<p class="text-center text-gray-500">Belum ada lowongan kerja yang tersedia saat ini.</p>';
                return;
            }

            jobs.forEach(job => {
                const jobCard = `
                    <div class="bg-white p-6 rounded-xl shadow-lg flex flex-col md:flex-row justify-between items-start md:items-center">
                        <div class="flex-grow">
                            <div class="flex items-center space-x-2 text-gray-500 mb-2">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-briefcase"><rect width="20" height="14" x="2" y="7" rx="2" ry="2"/><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/><line x1="12" x2="12" y1="12" y2="17"/></svg>
                                <span>${job.posisi}</span>
                            </div>
                            <h3 class="text-xl font-bold text-gray-800">${job.posisi}</h3>
                            <p class="text-gray-600 mb-2">${job.perusahaan || 'PT XMLTronik'}</p>
                            
                            <div class="flex items-center text-gray-500 text-sm mb-4">
                                <div class="flex items-center mr-4">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-map-pin mr-1"><path d="M12 21.75s-7-5.5-7-10.5a7 7 0 0 1 14 0c0 5-7 10.5-7 10.5z"/><circle cx="12" cy="10" r="3"/></svg>
                                    <span>${job.lokasi || 'Cilacap'}</span>
                                </div>
                                <div class="flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-clock mr-1"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                                    <span>${timeAgo(job.tgl_post)}</span>
                                </div>
                            </div>
                            
                            <p class="text-gray-600 mb-4">${job.deskripsi_singkat || 'Kualifikasi: Laki laki, usia maks 30 tahun, Pendidikan minimal SMK, Memiliki pengalaman relevan, Dapat bekerja secara tim.'}</p>

                            <button onclick="showJobDetails(${job.id_job})" class="text-blue-500 font-semibold hover:underline">View More</button>
                        </div>
                        <div class="mt-4 md:mt-0">
                            <button onclick="applyJob(${job.id_job})" class="bg-orange-500 text-white font-semibold py-2 px-6 rounded-lg btn-hover w-full md:w-auto">Lamar Sekarang</button>
                        </div>
                    </div>
                `;
                container.innerHTML += jobCard;
            });
        }

        async function showJobDetails(jobId) {
            try {
                const jobResponse = await fetch(`${API_URL}/jobs/${jobId}`);
                const jobData = await jobResponse.json();

                if (!jobResponse.ok) {
                    throw new Error('Failed to load job details.');
                }

                const fieldResponse = await fetch(`${API_URL}/field-job/byJob/${jobId}`);
                const fieldData = await fieldResponse.json();
                let fieldHtml = '';
                if (fieldData.data && fieldData.data.length > 0) {
                    fieldData.data.forEach(field => {
                        fieldHtml += `<h4 class="font-semibold mt-4">${field.judul}</h4>`;
                        fieldHtml += `<p>${field.deskripsi}</p>`;
                    });
                } else {
                    fieldHtml = '<p>Detail kualifikasi dan job desk tidak tersedia.</p>';
                }

                document.getElementById('modal-job-title').innerText = jobData.posisi;
                document.getElementById('modal-job-content').innerHTML = `
                    <div class="space-y-4">
                        <div class="p-4 bg-gray-100 rounded-lg">
                            <h4 class="font-bold text-lg mb-2">Deskripsi Pekerjaan</h4>
                            <p>${jobData.deskripsi_pekerjaan || 'Tidak ada deskripsi pekerjaan.'}</p>
                        </div>
                        <div class="p-4 bg-gray-100 rounded-lg">
                            <h4 class="font-bold text-lg mb-2">Kualifikasi</h4>
                            <p>${jobData.kualifikasi || 'Tidak ada kualifikasi.'}</p>
                        </div>
                        <div class="p-4 bg-gray-100 rounded-lg">
                            <h4 class="font-bold text-lg mb-2">Informasi Tambahan</h4>
                            ${fieldHtml}
                        </div>
                    </div>
                `;
                document.getElementById('job-detail-modal').style.display = 'flex';
            } catch (error) {
                console.error('Error fetching job details:', error);
                alert('Gagal memuat detail lowongan. Silakan coba lagi.');
            }
        }

        function closeModal() {
            document.getElementById('job-detail-modal').style.display = 'none';
        }

        function applyJob(jobId) {
            alert(`Anda akan diarahkan ke halaman form lamaran untuk Job ID: ${jobId}.`);
        }

        function timeAgo(dateString) {
            const now = new Date();
            const past = new Date(dateString);
            const diffInSeconds = Math.floor((now - past) / 1000);
            
            const intervals = [
                { label: 'tahun', seconds: 31536000 },
                { label: 'bulan', seconds: 2592000 },
                { label: 'hari', seconds: 86400 },
                { label: 'jam', seconds: 3600 },
                { label: 'menit', seconds: 60 },
                { label: 'detik', seconds: 1 }
            ];

            for (let i = 0; i < intervals.length; i++) {
                const interval = intervals[i];
                const count = Math.floor(diffInSeconds / interval.seconds);
                if (count >= 1) {
                    return `${count} ${interval.label} yang lalu`;
                }
            }
            return 'Baru saja diposting';
        }

        function searchJobs() {
            const keywords = document.getElementById('keywords').value.toLowerCase();
            const education = document.getElementById('education-filter').value.toLowerCase();
            const jobType = document.getElementById('job-type-filter').value.toLowerCase();
            const location = document.getElementById('location-filter').value.toLowerCase();

            const allJobCards = document.querySelectorAll('#job-listings > div');
            allJobCards.forEach(card => {
                const title = card.querySelector('h3').innerText.toLowerCase();
                const description = card.querySelector('p').innerText.toLowerCase();
                const cardLocation = card.querySelector('div.flex.items-center.text-gray-500.text-sm.mb-4 > div:nth-child(1) > span').innerText.toLowerCase();

                const isMatch = (title.includes(keywords) || description.includes(keywords)) &&
                                (education === '' || description.includes(education)) &&
                                (jobType === '' || description.includes(jobType)) &&
                                (location === '' || cardLocation.includes(location));

                card.style.display = isMatch ? 'flex' : 'none';
            });
        }
    </script>
</body>
</html>
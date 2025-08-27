<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Models\FormField;
use App\Models\Job;
use Illuminate\Support\Str;

class AdminController extends Controller
{
    public function dashboard()
    {
        // ...
        return view('admin.dashboard');
    }
    private string $baseUrl;

    public function __construct()
    {
        $this->baseUrl = config('services.api_backend.base_url', 'http://localhost:8080');
    }

    /* ==========================================================
     * JOBS MANAGEMENT
     * ========================================================== */
    public function listJobs()
    {
        try {
            $response = Http::get("{$this->baseUrl}/api/jobs")->throw();
            $jobs = $response->json();
            $jobs = is_array($jobs) ? $jobs : [];
        } catch (\Exception $e) {
            Log::error('Error fetching jobs: ' . $e->getMessage());
            $jobs = [];
        }
        return view('admin.list-jobs', compact('jobs'));
    }

    public function showJobForm()
    {
        return view('admin.create-job');
    }

    public function storeJob(Request $request)
    {
        $validated = $request->validate([
            'posisi'      => 'required|string|max:255',
            'deskripsi'   => 'required|string',
            'jobdesk'     => 'required|string',
            'kualifikasi' => 'required|string',
            'lokasi'      => 'required|string|max:255',
            'status'      => 'nullable|string|in:aktif,nonaktif',
            'tanggal_post' => 'required|date'
        ]);

        $payload = [
            'posisi'      => $validated['posisi'],
            'deskripsi'   => $validated['deskripsi'],
            'jobdesk'     => $validated['jobdesk'],
            'kualifikasi' => $validated['kualifikasi'],
            'lokasi'      => $validated['lokasi'],
            'tanggal_post' => $validated['tanggal_post'],
            'status'      => $validated['status'] ?? 'aktif',
            'pendidikan_min' => null,
            'image_url' => null,
            'batas_lamaran' => null
        ];

        try {
            Http::post("{$this->baseUrl}/api/jobs", $payload)->throw();
            return redirect()->route('admin.jobs.list')->with('success', 'Job berhasil ditambahkan.');
        } catch (\Exception $e) {
            Log::error('Error storing job: ' . $e->getMessage());
            return back()->withInput()->with('error', 'Gagal menambahkan job.');
        }
    }

    public function editJob($id)
    {
        try {
            $job = Http::get("{$this->baseUrl}/api/jobs/{$id}")->throw()->json();
        } catch (\Exception $e) {
            Log::error('Error fetching job: ' . $e->getMessage());
            return redirect()->route('admin.jobs.list')->with('error', 'Job tidak ditemukan.');
        }
        return view('admin.create-job', compact('job'));
    }

    public function updateJob(Request $request, $id)
    {
        $validated = $request->validate([
            'posisi'      => 'required|string|max:255',
            'deskripsi'   => 'required|string',
            'jobdesk'     => 'required|string',
            'kualifikasi' => 'required|string',
            'lokasi'      => 'required|string|max:255',
            'status'      => 'nullable|string|in:aktif,nonaktif',
            'tanggal_post' => 'required|date'
        ]);

        $payload = [
            'posisi'      => $validated['posisi'],
            'deskripsi'   => $validated['deskripsi'],
            'jobdesk'     => $validated['jobdesk'],
            'kualifikasi' => $validated['kualifikasi'],
            'lokasi'      => $validated['lokasi'],
            'tanggal_post' => $validated['tanggal_post'],
            'status'      => $validated['status'] ?? 'aktif',
            'pendidikan_min' => null,
            'image_url' => null,
            'batas_lamaran' => null
        ];

        try {
            Http::put("{$this->baseUrl}/api/jobs/{$id}", $payload)->throw();
            return redirect()->route('admin.jobs.list')->with('success', 'Job berhasil diperbarui.');
        } catch (\Exception $e) {
            Log::error('Error updating job: ' . $e->getMessage());
            return back()->withInput()->with('error', 'Gagal memperbarui job.');
        }
    }

    public function deleteJob($id)
    {
        try {
            Http::delete("{$this->baseUrl}/api/jobs/{$id}")->throw();
            return redirect()->route('admin.jobs.list')->with('success', 'Job berhasil dihapus.');
        } catch (\Exception $e) {
            Log::error('Error deleting job: ' . $e->getMessage());
            return redirect()->route('admin.jobs.list')->with('error', 'Gagal menghapus job.');
        }
    }

    public function activateJob($id)
    {
        try {
            Http::put("{$this->baseUrl}/api/jobs/{$id}/status", ['status' => 'aktif'])->throw();
            return redirect()->route('admin.jobs.list')->with('success', 'Job berhasil diaktifkan.');
        } catch (\Exception $e) {
            Log::error('Error activating job: ' . $e->getMessage());
            return redirect()->route('admin.jobs.list')->with('error', 'Gagal mengaktifkan job.');
        }
    }

    public function deactivateJob($id)
    {
        try {
            Http::put("{$this->baseUrl}/api/jobs/{$id}/status", ['status' => 'nonaktif'])->throw();
            return redirect()->route('admin.jobs.list')->with('success', 'Job berhasil dinonaktifkan.');
        } catch (\Exception $e) {
            Log::error('Error deactivating job: ' . $e->getMessage());
            return redirect()->route('admin.jobs.list')->with('error', 'Gagal menonaktifkan job.');
        }
    }

    /* ==========================================================
     * PELAMAR MANAGEMENT
     * ========================================================== */
    public function listPelamar()
    {
        try {
            // Ambil data pelamar dari API
            $responsePelamar = Http::get("{$this->baseUrl}/api/pelamar")->throw();
            $pelamar = $responsePelamar->json();
            $pelamar = is_array($pelamar) ? $pelamar : [];

            // Ambil data jobs dari API
            $responseJobs = Http::get("{$this->baseUrl}/api/jobs")->throw();
            $jobs = $responseJobs->json();
            $jobs = is_array($jobs) ? $jobs : [];

            // Map id_job => posisi
            $jobMap = collect($jobs)->keyBy('id_job')->map(fn($j) => $j['posisi'])->all();

            // Tambahkan posisi_dilamar ke setiap pelamar
            foreach ($pelamar as $key => $p) {
                $idJob = $p['id_job'] ?? null;
                $pelamar[$key]['posisi_dilamar'] = $idJob && isset($jobMap[$idJob])
                    ? $jobMap[$idJob]
                    : 'N/A';
            }

        } catch (\Exception $e) {
            Log::error('Error fetching pelamar or jobs: ' . $e->getMessage());
            $pelamar = [];
        }

        return view('admin.list-pelamar', compact('pelamar'));
    }

    public function viewPelamar($id)
    {
        try {
            $pelamar = Http::get("{$this->baseUrl}/api/pelamar/{$id}")->throw()->json();
            if (!is_array($pelamar)) {
                return redirect()->route('admin.pelamar.list')->with('error', 'Data pelamar tidak valid.');
            }
        } catch (\Exception $e) {
            Log::error('Error fetching pelamar detail: ' . $e->getMessage());
            return redirect()->route('admin.pelamar.list')->with('error', 'Data pelamar tidak ditemukan.');
        }

        return view('admin.view-pelamar', compact('pelamar'));
    }

    public function editPelamar($id)
    {
        try {
            $pelamar = Http::get("{$this->baseUrl}/api/pelamar/{$id}")->throw()->json();
        } catch (\Exception $e) {
            Log::error('Error fetching pelamar for edit: ' . $e->getMessage());
            return redirect()->route('admin.pelamar.list')->with('error', 'Data pelamar tidak ditemukan.');
        }

        return view('admin.edit-pelamar', compact('pelamar'));
    }

    public function updatePelamar(Request $request, $id)
    {
        $validated = $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'email'        => 'required|email',
            'no_hp'        => 'required|string|max:20',
            'alamat'       => 'nullable|string',
            'status'       => 'nullable|string|in:pending,diterima,ditolak,lolos,tidak_lolos',
        ]);

        try {
            Http::put("{$this->baseUrl}/api/pelamar/{$id}", $validated)->throw();
            return redirect()->route('admin.pelamar.list')->with('success', 'Data pelamar berhasil diperbarui.');
        } catch (\Exception $e) {
            Log::error('Error updating pelamar: ' . $e->getMessage());
            return back()->withInput()->with('error', 'Gagal memperbarui data pelamar.');
        }
    }

    public function acceptPelamar($id)
    {
        try {
            Http::post("{$this->baseUrl}/api/pelamar/{$id}/done")->throw();
            return redirect()->route('admin.pelamar.list')->with('success', 'Pelamar berhasil diterima.');
        } catch (\Exception $e) {
            Log::error('Error accepting pelamar: ' . $e->getMessage());
            return redirect()->route('admin.pelamar.list')->with('error', 'Gagal menerima pelamar.');
        }
    }

    public function rejectPelamar($id)
    {
        try {
            Http::post("{$this->baseUrl}/api/pelamar/{$id}/reject")->throw();
            return redirect()->route('admin.pelamar.list')->with('success', 'Pelamar berhasil ditolak.');
        } catch (\Exception $e) {
            Log::error('Error rejecting pelamar: ' . $e->getMessage());
            return redirect()->route('admin.pelamar.list')->with('error', 'Gagal menolak pelamar.');
        }
    }

    public function updateStatusPelamar(Request $request, $id)
    {
        $validated = $request->validate([
            'status' => 'required|string|in:pending,diterima,ditolak,lolos,tidak_lolos',
        ]);

        try {
            Http::put("{$this->baseUrl}/api/pelamar/{$id}/status", $validated)->throw();
            return redirect()->route('admin.pelamar.list')->with('success', 'Status pelamar berhasil diperbarui.');
        } catch (\Exception $e) {
            Log::error('Error updating status pelamar: ' . $e->getMessage());
            return redirect()->route('admin.pelamar.list')->with('error', 'Gagal memperbarui status pelamar.');
        }
    }

    /* ==========================================================
     * FORM LAMARAN (Public)
     * ========================================================== */
    public function showFormLamaran()
    {
        try {
            $jobs = Http::get("{$this->baseUrl}/api/jobs")->throw()->json();
            $jobs = is_array($jobs) ? $jobs : [];
        } catch (\Exception $e) {
            Log::error('Error fetching jobs for lamaran: ' . $e->getMessage());
            $jobs = [];
        }
        return view('admin.form-lamaran', compact('jobs'));
    }

    public function storeFormLamaran(Request $request)
    {
        $validatedData = $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'tempat_lahir' => 'nullable|string|max:50',
            'tanggal_lahir' => 'nullable|date',
            'umur' => 'nullable|integer',
            'alamat' => 'nullable|string',
            'no_hp' => 'required|string|max:20',
            'email' => 'required|email',
            'pendidikan_terakhir' => 'nullable|string|max:50',
            'nama_sekolah' => 'nullable|string|max:100',
            'jurusan' => 'nullable|string|max:100',
            'pengetahuan_perusahaan' => 'nullable|string',
            'bersedia_cilacap' => 'nullable|string|in:bersedia,tidak bersedia',
            'keahlian' => 'nullable|string',
            'tujuan_daftar' => 'nullable|string',
            'kelebihan' => 'nullable|string',
            'kekurangan' => 'nullable|string',
            'sosmed_aktif' => 'nullable|string|max:100',
            'alasan_merekrut' => 'nullable|string',
            'kelebihan_dari_yang_lain' => 'nullable|string',
            'alasan_bekerja_dibawah_tekanan' => 'nullable|string',
            'kapan_bisa_gabung' => 'nullable|string|max:50',
            'ekspektasi_gaji' => 'nullable|string|max:50',
            'alasan_ekspektasi' => 'nullable|string',
            'job_id' => 'required|integer',
            'cv' => 'nullable|file|mimes:pdf,doc,docx|max:2048',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        try {
            $multipart = [];
            foreach ($validatedData as $key => $value) {
                if (!in_array($key, ['cv', 'foto'])) {
                    $multipart[] = ['name' => $key, 'contents' => $value];
                }
            }

            if ($request->hasFile('cv')) {
                $multipart[] = [
                    'name' => 'cv',
                    'contents' => fopen($request->file('cv')->getPathname(), 'r'),
                    'filename' => $request->file('cv')->getClientOriginalName(),
                ];
            }

            if ($request->hasFile('foto')) {
                $multipart[] = [
                    'name' => 'foto',
                    'contents' => fopen($request->file('foto')->getPathname(), 'r'),
                    'filename' => $request->file('foto')->getClientOriginalName(),
                ];
            }

            Http::asMultipart()->post("{$this->baseUrl}/api/pelamar", $multipart)->throw();

            return redirect()->route('admin.pelamar.list')->with('success', 'Lamaran berhasil dikirim.');
        } catch (\Exception $e) {
            Log::error('Error submitting lamaran: ' . $e->getMessage());
            return back()->withInput()->with('error', 'Gagal mengirim lamaran.');
        }
    }

    /* ==========================================================
     * MANAJEMEN PERTANYAAN TAMBAHAN
     * ========================================================== */
    public function showEditFormLamaran()
    {
        $jobs = [];
        $formFields = collect();

        try {
            $response = Http::get("{$this->baseUrl}/api/jobs")->throw();
            $jobs = $response->json();
            $jobs = is_array($jobs) ? $jobs : [];

            $formFields = FormField::with('job')->get();
        } catch (\Exception $e) {
            Log::error('Error fetching jobs or form fields: ' . $e->getMessage());
        }

        return view('admin.edit-form-lamaran', compact('jobs', 'formFields'));
    }

    public function storePertanyaan(Request $request)
    {
        $validated = $request->validate([
            'label'  => 'required|string|max:255',
            'id_job' => 'required|integer|exists:jobs,id',
        ]);

        try {
            FormField::create([
                'id_job'     => $validated['id_job'],
                'label'      => $validated['label'],
                'nama_field' => 'pertanyaan_tambahan_' . Str::slug($validated['label'], '_'),
                'tipe'       => 'textarea',
                'wajib'      => 1,
                'urutan'     => FormField::where('id_job', $validated['id_job'])->max('urutan') + 1,
            ]);

            return back()->with('success', 'Pertanyaan berhasil ditambahkan.');
        } catch (\Exception $e) {
            Log::error('Error storing new form field: ' . $e->getMessage());
            return back()->with('error', 'Gagal menambahkan pertanyaan.');
        }
    }

    public function updatePertanyaan(Request $request, $id)
    {
        $validated = $request->validate([
            'label' => 'required|string|max:255',
        ]);

        try {
            $formField = FormField::findOrFail($id);
            $formField->label = $validated['label'];
            $formField->save();

            return back()->with('success', 'Pertanyaan berhasil diperbarui.');
        } catch (\Exception $e) {
            Log::error('Error updating form field: ' . $e->getMessage());
            return back()->with('error', 'Gagal memperbarui pertanyaan.');
        }
    }
    public function deletePertanyaan($id)
    {
        try {
            FormField::findOrFail($id)->delete();
            return back()->with('success', 'Pertanyaan berhasil dihapus.');
        } catch (\Exception $e) {
            Log::error('Error deleting form field: ' . $e->getMessage());
            return back()->with('error', 'Gagal menghapus pertanyaan.');
        }
    }
}

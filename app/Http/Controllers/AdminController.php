<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Models\PertanyaanTambahan; // Pastikan Anda memiliki model ini

class AdminController extends Controller
{
    private string $baseUrl;

    public function __construct()
    {
        $this->baseUrl = config('services.api_backend.base_url', 'http://localhost:8080');
    }

    /**
     * Dashboard Admin
     */
    public function dashboard()
    {
        return view('admin.dashboard');
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
            'deskripsi_job' => 'required|string',
        ]);

        try {
            Http::post("{$this->baseUrl}/api/jobs", $validated)->throw();
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
            'posisi'    => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'status'    => 'nullable|string|in:aktif,nonaktif',
        ]);

        $payload = array_filter($validated, fn($v) => !is_null($v));

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
            $pelamar = Http::get('http://localhost:8080/api/pelamar')->throw()->json();
            $pelamar = is_array($pelamar) ? $pelamar : [];
        } catch (\Exception $e) {
            Log::error('Error fetching pelamar: ' . $e->getMessage());
            $pelamar = [];
        }

        return view('admin.list-pelamar', compact('pelamar'));
    }

    public function viewPelamar($id)
    {
        try {
            $pelamar = Http::get("http://localhost:8080/api/pelamar/{$id}")->throw()->json();
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
            $pelamar = Http::get("http://localhost:8080/api/pelamar/{$id}")->throw()->json();
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
            Http::put("http://localhost:8080/api/pelamar/{$id}", $validated)->throw();
            return redirect()->route('admin.pelamar.list')->with('success', 'Data pelamar berhasil diperbarui.');
        } catch (\Exception $e) {
            Log::error('Error updating pelamar: ' . $e->getMessage());
            return back()->withInput()->with('error', 'Gagal memperbarui data pelamar.');
        }
    }

    public function acceptPelamar($id)
    {
        try {
            Http::post("http://localhost:8080/api/pelamar/{$id}/done")->throw();
            return redirect()->route('admin.pelamar.list')->with('success', 'Pelamar berhasil diterima.');
        } catch (\Exception $e) {
            Log::error('Error accepting pelamar: ' . $e->getMessage());
            return redirect()->route('admin.pelamar.list')->with('error', 'Gagal menerima pelamar.');
        }
    }

    public function rejectPelamar($id)
    {
        try {
            Http::post("http://localhost:8080/api/pelamar/{$id}/reject")->throw();
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
            Http::put("http://localhost:8080/api/pelamar/{$id}/status", $validated)->throw();
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
            $jobs = Http::get('http://localhost:8080/api/jobs')->throw()->json();
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

            Http::asMultipart()->post('http://localhost:8080/api/pelamar', $multipart)->throw();

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
        // Inisialisasi variabel di luar blok try...catch
        $jobs = [];
        $pertanyaan = collect(); // Menggunakan collect() atau [] adalah pilihan yang baik

        try {
            // Ambil semua pertanyaan tambahan dari database
            $pertanyaan = PertanyaanTambahan::all();

            // Ambil data jobs (tetap relevan untuk dropdown)
            $response = Http::get("http://localhost:8080/api/jobs")->throw();
            $jobs = $response->json();
            $jobs = is_array($jobs) ? $jobs : [];
        } catch (\Exception $e) {
            Log::error('Error fetching jobs or pertanyaan: ' . $e->getMessage());
            // Jika terjadi error, variabel $jobs dan $pertanyaan sudah memiliki nilai default
        }

        // Sekarang variabel $jobs dan $pertanyaan dijamin selalu ada
        return view('admin.edit-form-lamaran', compact('jobs', 'pertanyaan'));
    }

    public function storePertanyaan(Request $request)
    {
        $validated = $request->validate([
            'pertanyaan' => 'required|string|max:255',
        ]);

        try {
            PertanyaanTambahan::create([
                'pertanyaan' => $validated['pertanyaan']
            ]);

            return back()->with('success', 'Pertanyaan berhasil ditambahkan.');
        } catch (\Exception $e) {
            Log::error('Error storing new pertanyaan: ' . $e->getMessage());
            return back()->with('error', 'Gagal menambahkan pertanyaan.');
        }
    }

    public function updatePertanyaan(Request $request, $id)
    {
        $validated = $request->validate([
            'pertanyaan' => 'required|string|max:255',
        ]);

        try {
            $pertanyaan = PertanyaanTambahan::findOrFail($id);
            $pertanyaan->pertanyaan = $validated['pertanyaan'];
            $pertanyaan->save();

            return back()->with('success', 'Pertanyaan berhasil diperbarui.');
        } catch (\Exception $e) {
            Log::error('Error updating pertanyaan: ' . $e->getMessage());
            return back()->with('error', 'Gagal memperbarui pertanyaan.');
        }
    }

    public function deletePertanyaan($id)
    {
        try {
            PertanyaanTambahan::findOrFail($id)->delete();
            return back()->with('success', 'Pertanyaan berhasil dihapus.');
        } catch (\Exception $e) {
            Log::error('Error deleting pertanyaan: ' . $e->getMessage());
            return back()->with('error', 'Gagal menghapus pertanyaan.');
        }
    }
}

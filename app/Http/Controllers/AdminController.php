<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Mail\AcceptanceMail;
use App\Mail\RejectionMail;

class AdminController extends Controller
{
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
            $response = Http::get('http://localhost:8080/api/jobs');
            $response->throw();
            $jobs = $response->json();
            if (!is_array($jobs)) {
                $jobs = [];
            }
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
        try {
            $validated = $request->validate([
                'posisi'    => 'required|string|max:255',
                'deskripsi' => 'required|string',
                'status'    => 'nullable|string|in:aktif,nonaktif',
            ]);

            Http::post('http://localhost:8080/api/jobs', $validated)->throw();

            return redirect()->route('admin.jobs.list')->with('success', 'Job berhasil ditambahkan.');
        } catch (\Exception $e) {
            Log::error('Error storing job: ' . $e->getMessage());
            return redirect()->back()->withInput()->with('error', 'Gagal menambahkan job.');
        }
    }

    public function editJob($id)
    {
        try {
            $response = Http::get("http://localhost:8080/api/jobs/{$id}");
            $response->throw();
            $job = $response->json();
        } catch (\Exception $e) {
            Log::error('Error fetching job: ' . $e->getMessage());
            return redirect()->route('admin.jobs.list')->with('error', 'Job tidak ditemukan.');
        }

        return view('admin.create-job', compact('job'));
    }

    public function updateJob(Request $request, $id)
    {
        try {
            $validated = $request->validate([
                'posisi'    => 'required|string|max:255',
                'deskripsi' => 'required|string',
                'status'    => 'nullable|string|in:aktif,nonaktif',
            ]);

            Http::put("http://localhost:8080/api/jobs/{$id}", $validated)->throw();

            return redirect()->route('admin.jobs.list')->with('success', 'Job berhasil diperbarui.');
        } catch (\Exception $e) {
            Log::error('Error updating job: ' . $e->getMessage());
            return redirect()->back()->withInput()->with('error', 'Gagal memperbarui job.');
        }
    }

    public function deleteJob($id)
    {
        try {
            Http::delete("http://localhost:8080/api/jobs/{$id}")->throw();
            return redirect()->route('admin.jobs.list')->with('success', 'Job berhasil dihapus.');
        } catch (\Exception $e) {
            Log::error('Error deleting job: ' . $e->getMessage());
            return redirect()->route('admin.jobs.list')->with('error', 'Gagal menghapus job.');
        }
    }

    public function activateJob($id)
    {
        try {
            Http::put("http://localhost:8080/api/jobs/{$id}/status", ['status' => 'aktif'])->throw();
            return redirect()->route('admin.jobs.list')->with('success', 'Job berhasil diaktifkan.');
        } catch (\Exception $e) {
            Log::error('Error activating job: ' . $e->getMessage());
            return redirect()->route('admin.jobs.list')->with('error', 'Gagal mengaktifkan job.');
        }
    }

    public function deactivateJob($id)
    {
        try {
            Http::put("http://localhost:8080/api/jobs/{$id}/status", ['status' => 'nonaktif'])->throw();
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
            $response = Http::get('http://localhost:8080/api/pelamar');
            $response->throw();
            $pelamar = $response->json();
            if (!is_array($pelamar)) {
                $pelamar = [];
            }
        } catch (\Exception $e) {
            Log::error('Error fetching pelamar: ' . $e->getMessage());
            $pelamar = [];
        }

        return view('admin.list-pelamar', compact('pelamar'));
    }

    public function viewPelamar($id)
    {
        try {
            $response = Http::get("http://localhost:8080/api/pelamar/{$id}");
            $response->throw();
            $pelamar = $response->json();
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
            $response = Http::get("http://localhost:8080/api/pelamar/{$id}");
            $response->throw();
            $pelamar = $response->json();
        } catch (\Exception $e) {
            Log::error('Error fetching pelamar for edit: ' . $e->getMessage());
            return redirect()->route('admin.pelamar.list')->with('error', 'Data pelamar tidak ditemukan.');
        }

        return view('admin.edit-pelamar', compact('pelamar'));
    }

    public function updatePelamar(Request $request, $id)
    {
        try {
            $validated = $request->validate([
                'nama_lengkap' => 'required|string|max:255',
                'email'        => 'required|email',
                'no_hp'        => 'required|string|max:20',
                'alamat'       => 'nullable|string',
                'status'       => 'nullable|string|in:pending,diterima,ditolak,lolos,tidak_lolos',
            ]);

            Http::put("http://localhost:8080/api/pelamar/{$id}", $validated)->throw();

            return redirect()->route('admin.pelamar.list')->with('success', 'Data pelamar berhasil diperbarui.');
        } catch (\Exception $e) {
            Log::error('Error updating pelamar: ' . $e->getMessage());
            return redirect()->back()->withInput()->with('error', 'Gagal memperbarui data pelamar.');
        }
    }

    public function acceptPelamar($id)
    {
        try {
            Http::post("http://localhost:8080/api/pelamar/{$id}/done")->throw();
            return redirect()->route('admin.pelamar.list')->with('success', 'Pelamar berhasil diterima.');
        } catch (\Exception $e) {
            Log::error('Error accepting pelamar: ' . $e->getMessage());
            return redirect()->route('admin.pelamar.list')->with('error', 'Gagal menerima pelamar. Silakan periksa log.');
        }
    }

    public function rejectPelamar($id)
    {
        try {
            Http::post("http://localhost:8080/api/pelamar/{$id}/reject")->throw();
            return redirect()->route('admin.pelamar.list')->with('success', 'Pelamar berhasil ditolak.');
        } catch (\Exception $e) {
            Log::error('Error rejecting pelamar: ' . $e->getMessage());
            return redirect()->route('admin.pelamar.list')->with('error', 'Gagal menolak pelamar. Silakan periksa log.');
        }
    }

    public function updateStatusPelamar(Request $request, $id)
    {
        try {
            $validated = $request->validate([
                'status' => 'required|string|in:pending,diterima,ditolak,lolos,tidak_lolos',
            ]);

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
            $response = Http::get('http://localhost:8080/api/jobs');
            $response->throw();
            $jobs = $response->json();
            if (!is_array($jobs)) {
                $jobs = [];
            }
        } catch (\Exception $e) {
            Log::error('Error fetching jobs for lamaran: ' . $e->getMessage());
            $jobs = [];
        }

        return view('admin.form-lamaran', compact('jobs'));
    }

    public function storeFormLamaran(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'nama_lengkap'              => 'required|string|max:255',
                'tempat_lahir'              => 'nullable|string|max:50',
                'tanggal_lahir'             => 'nullable|date',
                'umur'                      => 'nullable|integer',
                'alamat'                    => 'nullable|string',
                'no_hp'                     => 'required|string|max:20',
                'email'                     => 'required|email',
                'pendidikan_terakhir'       => 'nullable|string|max:50',
                'nama_sekolah'              => 'nullable|string|max:100',
                'jurusan'                   => 'nullable|string|max:100',
                'pengetahuan_perusahaan'    => 'nullable|string',
                'bersedia_cilacap'          => 'nullable|string|in:bersedia,tidak bersedia',
                'keahlian'                  => 'nullable|string',
                'tujuan_daftar'             => 'nullable|string',
                'kelebihan'                 => 'nullable|string',
                'kekurangan'                => 'nullable|string',
                'sosmed_aktif'              => 'nullable|string|max:100',
                'alasan_merekrut'           => 'nullable|string',
                'kelebihan_dari_yang_lain'  => 'nullable|string',
                'alasan_bekerja_dibawah_tekanan' => 'nullable|string',
                'kapan_bisa_gabung'         => 'nullable|string|max:50',
                'ekspektasi_gaji'           => 'nullable|string|max:50',
                'alasan_ekspektasi'         => 'nullable|string',
                'job_id'                    => 'required|integer',
                'cv'                        => 'nullable|file|mimes:pdf,doc,docx|max:2048',
                'foto'                      => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            ]);

            if ($request->hasFile('cv')) {
                $validatedData['cv'] = $request->file('cv')->store('cv', 'public');
            }

            if ($request->hasFile('foto')) {
                $validatedData['foto'] = $request->file('foto')->store('foto', 'public');
            }

            Http::post('http://localhost:8080/api/pelamar', $validatedData)->throw();

            return redirect()->route('admin.pelamar.list')->with('success', 'Lamaran berhasil dikirim.');
        } catch (\Exception $e) {
            Log::error('Error submitting lamaran: ' . $e->getMessage());
            return redirect()->back()->withInput()->with('error', 'Gagal mengirim lamaran.');
        }
    }
}

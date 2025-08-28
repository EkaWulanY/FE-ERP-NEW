<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Job;
use App\Models\P_FormLamaran;
use App\Models\P_PengalamanKerja;
use Illuminate\Support\Facades\Http;

class P_PelamarController extends Controller
{
    /**
     * Halaman utama pelamar (daftar lowongan kerja aktif).
     */
    public function index()
    {
        $jobs = Job::where('status', 'aktif')
            ->orderBy('tanggal_post', 'desc')
            ->get();

        return view('p_pelamar_view', compact('jobs'));
    }

    /**
     * API untuk daftar lowongan aktif (JSON).
     */
    public function getAktifJobs()
    {
        $jobs = Job::where('status', 'aktif')
            ->orderBy('tanggal_post', 'desc')
            ->get();

        return response()->json($jobs);
    }

    /**
     * Form lamaran kerja.
     */
    public function create(Request $request)
    {
        $jobs = Job::where('status', 'aktif')->get();
        $selectedJobId = $request->query('id_job');
        return view('pelamar.form', compact('jobs', 'selectedJobId'));
    }

    /**
     * Simpan lamaran & pengalaman kerja.
     */
    public function store(Request $request)
    {
        // ✅ Validasi: id_job harus ada di tabel job
        $request->validate([
            'id_job' => 'required|exists:job,id_job',
            'nama_lengkap' => 'required|string|max:255',
            'email' => 'required|email',
            'no_hp' => 'required|string|max:20',
            'upload_berkas' => 'required|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:2048',
        ]);

        // Simpan file (kalau ada)
        $filePath = null;
        if ($request->hasFile('upload_berkas')) {
            $filePath = $request->file('upload_berkas')->store('berkas_pelamar', 'public');
        }

        // Simpan data lamaran
        $lamaran = P_FormLamaran::create([
            'id_job' => $request->id_job,
            'nama_lengkap' => $request->nama_lengkap,
            'tempat_lahir' => $request->tempat_lahir,
            'tanggal_lahir' => $request->tanggal_lahir,
            'umur' => $request->umur,
            'alamat' => $request->alamat,
            'no_hp' => $request->no_hp,
            'email' => $request->email,
            'pendidikan_terakhir' => $request->pendidikan_terakhir,
            'nama_sekolah' => $request->nama_sekolah,
            'jurusan' => $request->jurusan,
            'pengetahuan_perusahaan' => $request->pengetahuan_perusahaan,
            'bersedia_cilacap' => $request->bersedia_cilacap,
            'keahlian' => $request->keahlian,
            'tujuan_daftar' => $request->tujuan_daftar,
            'kelebihan' => $request->kelebihan,
            'kekurangan' => $request->kekurangan,
            'sosmed_aktif' => $request->sosmed_aktif,
            'alasan_merekrut' => $request->alasan_merekrut,
            'kelebihan_dari_yang_lain' => $request->kelebihan_dari_yang_lain,
            'alasan_bekerja_dibawah_tekanan' => $request->alasan_bekerja_dibawah_tekanan,
            'kapan_bisa_gabung' => $request->kapan_bisa_gabung,
            'ekspektasi_gaji' => $request->ekspektasi_gaji,
            'alasan_ekspektasi' => $request->alasan_ekspektasi,
            'upload_berkas' => $filePath,
        ]);

        // Simpan pengalaman kerja
        if ($request->has('pengalaman')) {
            foreach ($request->pengalaman as $exp) {
                if (!empty($exp['nama_perusahaan'])) {
                    P_PengalamanKerja::create([
                        'id_lamaran' => $lamaran->id_lamaran,
                        'nama_perusahaan' => $exp['nama_perusahaan'],
                        'tahun_mulai' => $exp['tahun_mulai'] ?? null,
                        'tahun_selesai' => $exp['tahun_selesai'] ?? null,
                        'posisi' => $exp['posisi'] ?? null,
                        'pengalaman' => $exp['pengalaman'] ?? null,
                        'alasan_resign' => $exp['alasan_resign'] ?? null,
                    ]);
                }
            }
        }

        return redirect()
            ->route('pelamar.show', $lamaran->id_lamaran)
            ->with('success', 'Lamaran berhasil dikirim!');
    }

    /**
     * Detail lowongan pekerjaan.
     */
    public function showJob($id)
    {
        $job = Job::where('id_job', $id)->first();

        if (!$job) {
            $response = Http::get("http://localhost:8080/api/jobs/$id");
            $job = $response->json();
        }

        return view('p_job_detail', compact('job'));
    }

    /**
     * Detail lamaran pelamar.
     */
    public function showLamaran($id)
    {
        $pelamar = P_FormLamaran::with('job')->findOrFail($id);
        return view('pelamar.detail', compact('pelamar'));
    }

    /**
     * Halaman verifikasi.
     */
    public function verifikasi($id)
    {
        $pelamar = P_FormLamaran::with('job')->findOrFail($id);
        return view('pelamar.verifikasi', compact('pelamar'));
    }
}

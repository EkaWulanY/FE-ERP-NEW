<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Job;
use App\Models\P_Job; // Hapus jika tidak digunakan atau ganti dengan 'Job'
use App\Models\P_FormLamaran;
use App\Models\P_PengalamanKerja;
use Illuminate\Support\Facades\Http; // Ini penting untuk fungsi show()

class P_PelamarController extends Controller
{
    /**
     * Menampilkan halaman utama untuk pelamar.
     * Halaman ini akan memuat daftar lowongan kerja aktif.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Kode asli dari file pertama: mengambil posisi unik untuk dropdown,
        // meskipun p_pelamar_view.blade.php yang Anda berikan tidak menggunakannya.
        // Namun, jika Anda membutuhkannya di masa depan, ini bisa menjadi kode yang relevan.
        // Jika tidak, kode ini dapat dihapus.
        $jobs = Job::select('posisi')->get()->unique('posisi');

        // Mengembalikan view yang akan menampilkan halaman utama pelamar.
        return view('p_pelamar_view', compact('jobs'));
    }

    /**
     * Mengambil daftar lowongan kerja yang berstatus 'aktif'.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getAktifJobs()
    {
        $jobs = Job::where('status', 'aktif')->orderBy('tanggal_post', 'desc')->get();
        return response()->json($jobs);
    }

    /**
     * Menampilkan form lamaran.
     *
     * @return \Illuminate\View\View
     */
    public function create(Request $request)
    {
        $jobs = \App\Models\Job::all();
        $selectedJobId = $request->query('id_job'); // ambil dari URL
        return view('pelamar.form', compact('jobs', 'selectedJobId'));
    }

    /**
     * Simpan data lamaran & pengalaman kerja.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        // Validasi input di sini (disarankan untuk keamanan)
        // ...

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
            'pengetahuan_perusahaan' => $request->pengetahuan_perusahaan,
            'kelebihan' => $request->kelebihan,
            'kekurangan' => $request->kekurangan,
            'sosmed_aktif' => $request->sosmed_aktif,
            'ekspektasi_gaji' => $request->ekspektasi_gaji,
            // Perhatikan penggunaan 'store' yang perlu diatur di filesystem config
            'upload_berkas' => $request->file('upload_berkas')?->store('berkas', 'public'),
        ]);

        if ($request->has('pengalaman')) {
            foreach ($request->pengalaman as $exp) {
                P_PengalamanKerja::create([
                    'id_lamaran' => $lamaran->id_lamaran,
                    'nama_perusahaan' => $exp['nama_perusahaan'],
                    'tahun_mulai' => $exp['tahun_mulai'],
                    'tahun_selesai' => $exp['tahun_selesai'],
                    'posisi' => $exp['posisi'],
                    'pengalaman' => $exp['pengalaman'],
                    'alasan_resign' => $exp['alasan_resign'],
                ]);
            }
        }

        return redirect()->route('pelamar.show', $lamaran->id_lamaran);
    }

    /**
     * Menampilkan detail lamaran (readonly).
     *
     * @param  string $id
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        // Mengambil data dari API eksternal, sesuai dengan file kedua.
        // Hati-hati: 'localhost' tidak akan bisa diakses dari lingkungan ini.
        // Anda perlu menggantinya dengan URL yang dapat diakses dari server Anda.
        $response = Http::get("http://localhost:8080/api/jobs/$id");
        $job = $response->json();

        // Mengembalikan view untuk detail job.
        return view('p_job_detail', compact('job'));
    }

    /**
     * Menampilkan halaman verifikasi (kirim ke WA).
     *
     * @param  string $id
     * @return \Illuminate\View\View
     */
    public function verifikasi($id)
    {
        $pelamar = P_FormLamaran::with('job')->findOrFail($id);
        return view('pelamar.verifikasi', compact('pelamar'));
    }
}

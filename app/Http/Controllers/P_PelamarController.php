<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Job; // Pastikan model Job sudah diimpor

class P_PelamarController extends Controller
{
    /**
     * Menampilkan halaman utama untuk pelamar dan memuat dropdown posisi.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $jobs = Job::select('posisi')->get()->unique('posisi');
        return view('p_pelamar_view', compact('jobs'));
    }

    /**
     * Mengambil daftar lowongan kerja yang berstatus 'aktif'.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getAktifJobs()
    {
        // Mengambil semua data lowongan dengan status 'aktif'
        // dan mengurutkannya berdasarkan tanggal terbaru
        $jobs = Job::where('status', 'aktif')->orderBy('tgl_post', 'desc')->get();

        // Mengembalikan data dalam format JSON
        return response()->json($jobs);
    }
}
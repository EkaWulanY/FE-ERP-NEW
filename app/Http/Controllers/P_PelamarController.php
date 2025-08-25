<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;

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
        return view('p_pelamar_view');
    }
}
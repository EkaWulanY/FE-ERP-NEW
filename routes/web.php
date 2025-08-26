<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\P_PelamarController;

// ROUTES UNTUK PELAMAR (Frontend)
Route::get('/lowongan-kerja', [P_PelamarController::class, 'index'])->name('pelamar.jobs');
Route::get('/api/jobs/aktif', [P_PelamarController::class, 'getAktifJobs']);

//----------------------------------------------------------------------------------

// ROUTES UNTUK ADMIN

// Dashboard
Route::get('/', [AdminController::class, 'dashboard'])->name('admin.dashboard');

// JOBS
Route::get('/jobs', [AdminController::class, 'listJobs'])->name('admin.jobs.list');
Route::get('/jobs/create', [AdminController::class, 'showJobForm'])->name('admin.jobs.create');
Route::post('/jobs', [AdminController::class, 'storeJob'])->name('admin.jobs.store');
Route::get('/jobs/{id}/edit', [AdminController::class, 'editJob'])->name('admin.jobs.edit');
Route::put('/jobs/{id}', [AdminController::class, 'updateJob'])->name('admin.jobs.update');
Route::delete('/jobs/{id}', [AdminController::class, 'deleteJob'])->name('admin.jobs.delete');
Route::put('/jobs/{id}/activate', [AdminController::class, 'activateJob'])->name('admin.jobs.activate');
Route::put('/jobs/{id}/deactivate', [AdminController::class, 'deactivateJob'])->name('admin.jobs.deactivate');

// PELAMAR
Route::get('/pelamar', [AdminController::class, 'listPelamar'])->name('admin.pelamar.list');
Route::get('/pelamar/{id}', [AdminController::class, 'viewPelamar'])->name('admin.pelamar.view');
Route::get('/pelamar/{id}/edit', [AdminController::class, 'editPelamar'])->name('admin.pelamar.edit');
Route::put('/pelamar/{id}', [AdminController::class, 'updatePelamar'])->name('admin.pelamar.update');
Route::post('/pelamar/{id}/accept', [AdminController::class, 'acceptPelamar'])->name('admin.pelamar.accept');
Route::post('/pelamar/{id}/reject', [AdminController::class, 'rejectPelamar'])->name('admin.pelamar.reject');
Route::put('/pelamar/{id}/update-status', [AdminController::class, 'updateStatusPelamar'])->name('admin.pelamar.update-status');

// Form Lamaran Kerja (untuk pelamar submit)
Route::get('/form/lamaran', [AdminController::class, 'showFormLamaran'])->name('admin.form.lamaran');
Route::post('/form/lamaran', [AdminController::class, 'storeFormLamaran'])->name('admin.form.lamaran.store');

// Perbaikan: Rute untuk Halaman Edit Form Lamaran
Route::get('/form/edit', [AdminController::class, 'showEditFormLamaran'])->name('admin.form.edit');

// Perbaikan: Rute untuk mengelola pertanyaan tambahan (CRUD)
Route::post('/form/pertanyaan', [AdminController::class, 'storePertanyaan'])->name('admin.form.pertanyaan.store');
Route::put('/form/pertanyaan/{id}', [AdminController::class, 'updatePertanyaan'])->name('admin.form.pertanyaan.update');
Route::delete('/form/pertanyaan/{id}', [AdminController::class, 'deletePertanyaan'])->name('admin.form.pertanyaan.delete');
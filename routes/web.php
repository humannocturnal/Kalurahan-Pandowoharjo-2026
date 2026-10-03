<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminAgendaController;
use App\Http\Controllers\AdminDukuhController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AgendaController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\KegiatanController;
use App\Http\Controllers\AdminKegiatanController;

// ===============================
// LOGIN
// ===============================

Route::get('/login', [AuthController::class, 'showLogin'])
    ->name('login');

Route::post('/login', [AuthController::class, 'login'])
    ->name('login.process');

// ===============================
// ROUTE ADMIN
// ===============================

Route::middleware('auth')->group(function () {

    Route::get('/admin', [
        AdminController::class,
        'index'
    ])->name('admin.dashboard');


    Route::get('/admin/dukuh', [
        AdminDukuhController::class,
        'index'
    ])->name('admin.dukuh');

    Route::get('/admin/dukuh/form', [
        AdminDukuhController::class,
        'form'
    ])->name('admin.dukuh.form');

    Route::post('/admin/dukuh', [
        AdminDukuhController::class,
        'store'
    ])->name('admin.dukuh.store');

    Route::get('/admin/dukuh/{id}/edit', [
        AdminDukuhController::class,
        'edit'
    ])->name('admin.dukuh.edit');

    Route::put('/admin/dukuh/{id}', [
        AdminDukuhController::class,
        'update'
    ])->name('admin.dukuh.update');

    Route::delete('/admin/dukuh/{id}', [
        AdminDukuhController::class,
        'destroy'
    ])->name('admin.dukuh.destroy');

    Route::get('/admin/agenda', [
        AdminAgendaController::class,
        'index'
    ])->name('admin.agenda');

    Route::get('/admin/agenda/form', [
        AdminAgendaController::class,
        'form'
    ])->name('admin.agenda.form');

    Route::post('/admin/agenda', [
        AdminAgendaController::class,
        'store'
    ])->name('admin.agenda.store');

    Route::get('/admin/agenda/{id}/edit', [
        AdminAgendaController::class,
        'edit'
    ])->name('admin.agenda.edit');

    Route::put('/admin/agenda/{id}', [
        AdminAgendaController::class,
        'update'
    ])->name('admin.agenda.update');

    Route::delete('/admin/agenda/{id}', [
        AdminAgendaController::class,
        'destroy'
    ])->name('admin.agenda.destroy');

    Route::get('/admin/agenda/{id}', [
        AdminAgendaController::class,
        'show'
    ])->name('admin.agenda.show');

    Route::delete('/admin/agenda/{agendaId}/foto/{fotoId}', [
        AdminAgendaController::class,
        'destroyFoto'
    ])->name('admin.agenda.foto.destroy');  

    // ======================================
    // REALISASI AGENDA MENJADI KEGIATAN
    // ======================================

    Route::get('/admin/agenda/{id}/realisasi', [
        AdminKegiatanController::class,
        'createFromAgenda'
    ])->whereNumber('id')
    ->name('admin.agenda.realisasi');

    Route::post('/admin/agenda/{id}/realisasi', [
        AdminKegiatanController::class,
        'storeFromAgenda'
    ])->whereNumber('id')
  ->name('admin.agenda.realisasi.store');

    Route::get('/admin/kegiatan', [
        AdminKegiatanController::class,
        'index'
    ])->name('admin.kegiatan');


    Route::get('/admin/kegiatan/form', [
        AdminKegiatanController::class,
        'form'
    ])->name('admin.kegiatan.form');


    Route::post('/admin/kegiatan', [
        AdminKegiatanController::class,
        'store'
    ])->name('admin.kegiatan.store');


    Route::get('/admin/kegiatan/{id}/edit', [
        AdminKegiatanController::class,
        'edit'
    ])->whereNumber('id')->name('admin.kegiatan.edit');


    Route::put('/admin/kegiatan/{id}', [
        AdminKegiatanController::class,
        'update'
    ])->whereNumber('id')->name('admin.kegiatan.update');


    Route::delete('/admin/kegiatan/{id}', [
        AdminKegiatanController::class,
        'destroy'
    ])->whereNumber('id')->name('admin.kegiatan.destroy');


    Route::delete('/admin/kegiatan/{kegiatanId}/foto/{fotoId}', [
        AdminKegiatanController::class,
        'destroyFoto'
    ])->whereNumber('kegiatanId')
    ->whereNumber('fotoId')
    ->name('admin.kegiatan.foto.destroy');

    Route::get('/admin/kegiatan/{id}', [
        AdminKegiatanController::class,
        'show'
    ])->whereNumber('id')->name('admin.kegiatan.show');
    // Logout
    
    Route::post('/logout', [AuthController::class, 'logout'])
        ->name('logout');
});

//HOME
Route::get('/', [
    HomeController::class,
    'index'
])->name('home');

// AGENDA
Route::get('/agenda', [
    AgendaController::class,
    'index'
])->name('agenda.index');

Route::get('/agenda/search/month/{month}/{year}', [
    AgendaController::class,
    'searchByMonth'
])->name('agenda.search.month');

Route::get('/agenda/{id}', [
    AgendaController::class,
    'show'
])->name('agenda.show');

// KEGIATAN PENGUNJUNG
Route::get('/kegiatan', [
    KegiatanController::class,
    'index'
])->name('kegiatan.index');

Route::get('/kegiatan/search/month/{month}/{year}', [
    KegiatanController::class,
    'searchByMonth'
])->name('kegiatan.search.month');

Route::get('/kegiatan/{id}', [
    KegiatanController::class,
    'show'
])->name('kegiatan.show');


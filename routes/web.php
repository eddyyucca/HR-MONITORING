<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\RekrutmenController;
use App\Http\Controllers\KaryawanController;
use App\Http\Controllers\MppController;
use App\Http\Controllers\MasterController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ImportController;

// Auth
Route::get('/login',  [AuthController::class, 'showLogin'])->name('login')->middleware('guest');
Route::post('/login', [AuthController::class, 'login'])->middleware('guest');
Route::post('/logout',[AuthController::class, 'logout'])->name('logout')->middleware('auth');

// Protected routes
Route::middleware(['auth'])->group(function () {

    // Dashboard
    Route::get('/',          [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard', [DashboardController::class, 'index']);

    // Dashboard API (untuk chart refresh)
    Route::get('/api/dashboard/stats', [DashboardController::class, 'stats'])->name('dashboard.stats');

    // ── REKRUTMEN ────────────────────────────────────────────
    Route::prefix('rekrutmen')->name('rekrutmen.')->group(function () {
        Route::get('/',                    [RekrutmenController::class, 'index'])->name('index');
        Route::get('/create',              [RekrutmenController::class, 'create'])->name('create');
        Route::get('/datatables/json',     [RekrutmenController::class, 'datatables'])->name('datatables');
        Route::get('/export/excel',        [RekrutmenController::class, 'exportExcel'])->name('export.excel');
        Route::post('/',                   [RekrutmenController::class, 'store'])->name('store');
        Route::post('/import',             [ImportController::class, 'importRekrutmen'])->name('import');
        Route::get('/{id}',                [RekrutmenController::class, 'show'])->name('show');
        Route::get('/{id}/edit',           [RekrutmenController::class, 'edit'])->name('edit');
        Route::put('/{id}',                [RekrutmenController::class, 'update'])->name('update');
        Route::delete('/{id}',             [RekrutmenController::class, 'destroy'])->name('destroy');
    });

    // ── KARYAWAN ─────────────────────────────────────────────
    Route::prefix('karyawan')->name('karyawan.')->group(function () {
        Route::get('/',                    [KaryawanController::class, 'index'])->name('index');
        Route::get('/create',              [KaryawanController::class, 'create'])->name('create');
        Route::get('/datatables/json',     [KaryawanController::class, 'datatables'])->name('datatables');
        Route::get('/export/excel',        [KaryawanController::class, 'exportExcel'])->name('export.excel');
        Route::get('/staff',               [KaryawanController::class, 'staff'])->name('staff');
        Route::get('/non-staff',           [KaryawanController::class, 'nonStaff'])->name('non-staff');
        Route::post('/',                   [KaryawanController::class, 'store'])->name('store');
        Route::post('/import',             [ImportController::class, 'importKaryawan'])->name('import');
        Route::get('/{id}',                [KaryawanController::class, 'show'])->name('show');
        Route::get('/{id}/edit',           [KaryawanController::class, 'edit'])->name('edit');
        Route::put('/{id}',                [KaryawanController::class, 'update'])->name('update');
        Route::delete('/{id}',             [KaryawanController::class, 'destroy'])->name('destroy');
    });

    // ── MPP ──────────────────────────────────────────────────
    Route::prefix('mpp')->name('mpp.')->group(function () {
        Route::get('/',                    [MppController::class, 'index'])->name('index');
        Route::get('/create',              [MppController::class, 'create'])->name('create');
        Route::get('/datatables/json',     [MppController::class, 'datatables'])->name('datatables');
        Route::get('/export/excel',        [MppController::class, 'exportExcel'])->name('export.excel');
        Route::get('/gap-analysis',        [MppController::class, 'gapAnalysis'])->name('gap');
        Route::post('/',                   [MppController::class, 'store'])->name('store');
        Route::post('/import',             [ImportController::class, 'importMpp'])->name('import');
        Route::get('/{id}',                [MppController::class, 'show'])->name('show');
        Route::get('/{id}/edit',           [MppController::class, 'edit'])->name('edit');
        Route::put('/{id}',                [MppController::class, 'update'])->name('update');
        Route::delete('/{id}',             [MppController::class, 'destroy'])->name('destroy');
    });

    // ── MASTER DATA ──────────────────────────────────────────
    Route::prefix('master')->name('master.')->middleware('can-edit')->group(function () {
        // CRUD divisi
        Route::get('/divisi',            [MasterController::class, 'divisiIndex'])->name('divisi.index');
        Route::post('/divisi',           [MasterController::class, 'divisiStore'])->name('divisi.store');
        Route::put('/divisi/{id}',       [MasterController::class, 'divisiUpdate'])->name('divisi.update');
        Route::delete('/divisi/{id}',    [MasterController::class, 'divisiDestroy'])->name('divisi.destroy');

        // CRUD departemen
        Route::get('/departemen',        [MasterController::class, 'deptIndex'])->name('departemen.index');
        Route::post('/departemen',       [MasterController::class, 'deptStore'])->name('departemen.store');
        Route::put('/departemen/{id}',   [MasterController::class, 'deptUpdate'])->name('departemen.update');
        Route::delete('/departemen/{id}',[MasterController::class, 'deptDestroy'])->name('departemen.destroy');

        // CRUD jabatan
        Route::get('/jabatan',           [MasterController::class, 'jabatanIndex'])->name('jabatan.index');
        Route::post('/jabatan',          [MasterController::class, 'jabatanStore'])->name('jabatan.store');
        Route::put('/jabatan/{id}',      [MasterController::class, 'jabatanUpdate'])->name('jabatan.update');
        Route::delete('/jabatan/{id}',   [MasterController::class, 'jabatanDestroy'])->name('jabatan.destroy');
    });

    // ── USERS ────────────────────────────────────────────────
    Route::prefix('users')->name('users.')->middleware('role:admin')->group(function () {
        Route::get('/',          [UserController::class, 'index'])->name('index');
        Route::get('/create',    [UserController::class, 'create'])->name('create');
        Route::post('/',         [UserController::class, 'store'])->name('store');
        Route::get('/{id}/edit', [UserController::class, 'edit'])->name('edit');
        Route::put('/{id}',      [UserController::class, 'update'])->name('update');
        Route::delete('/{id}',   [UserController::class, 'destroy'])->name('destroy');
    });

    // Profile
    Route::get('/profile',       [UserController::class, 'profile'])->name('profile');
    Route::put('/profile',       [UserController::class, 'updateProfile'])->name('profile.update');
    Route::put('/profile/password', [UserController::class, 'updatePassword'])->name('profile.password');

    // Ajax helpers
    Route::get('/ajax/departemen-by-divisi/{divisi_id}', [MasterController::class, 'deptByDivisi'])->name('ajax.dept');
    Route::get('/ajax/jabatan-by-dept/{dept_id}',        [MasterController::class, 'jabatanByDept'])->name('ajax.jabatan');
});

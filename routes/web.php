<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Models\Obat;
use Illuminate\Support\Facades\Route;
use Rubix\ML\Datasets\Labeled;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
//route menuju halaman home
Route::get('/', function () {
    return view('pages.landing.index', [
        'title' => 'Gudang Farmasi | Home',
        'page' => 'landing-home',
    ]);
});
//route menuju halaman about
Route::get('/about', function () {
    return view('pages.landing.about', [
        'title' => 'Gudang Farmasi | About',
        'page' => 'landing-about',
    ]);
});
//rpute menuju halaman obat
Route::get('/obat', function () {
    return view('pages.landing.obat', [
        'title' => 'Gudang Farmasi | Obat',
        'page' => 'landing-obat',
    ]);
});

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('/login', [AuthenticatedSessionController::class, 'store']);
});

Route::middleware('auth')->group(function () {
    Route::get('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');
    Route::prefix('panel')->group(function () {
        Route::get('/', function () {
            return view('pages.panel.index', [
                'title' => 'Gudang Farmasi | Dashboard',
                'page' => 'panel-dashboard',
            ]);
        });
        Route::get('/obat', function () {
            return view('pages.panel.obat', [
                'title' => 'Gudang Farmasi | Data Obat',
                'page' => 'panel-obat',
            ]);
        });
        Route::get('/prediksi', function () {
            return view('pages.panel.prediksi', [
                'title' => 'Gudang Farmasi | Proses Prediksi',
                'obat' => Obat::all(),
                'page' => 'panel-prediksi',
            ]);
        });
        Route::get('/masuk', function () {
            return view('pages.panel.masuk', [
                'title' => 'Gudang Farmasi | Obat Masuk',
                'obat' => Obat::all(),
                'page' => 'panel-masuk',
            ]);
        });
        Route::get('/keluar', function () {
            return view('pages.panel.keluar', [
                'title' => 'Gudang Farmasi | Obat Keluar',
                'obat' => Obat::all(),
                'page' => 'panel-keluar',
            ]);
        });
        Route::get('/laporan', function () {
            return view('pages.panel.laporan', [
                'title' => 'Gudang Farmasi | LPLPO',
                'page' => 'panel-laporan',
            ]);
        });
        Route::get('/pengguna', function () {
            return view('pages.panel.pengguna', [
                'title' => 'Gudang Farmasi | Data Pengguna',
                'page' => 'panel-pengguna',
            ]);
        });
    });
});

require base_path('routes/api.php');

<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LatesController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\RayonsController;
use App\Http\Controllers\RombelsController;
use App\Http\Controllers\StudentsController;
use App\Http\Controllers\PembimbingSiswaController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Inilah tempat Anda dapat mendaftarkan rute web untuk aplikasi Anda.
| Rute-rute ini dimuat oleh RouteServiceProvider dan semuanya akan
| dialokasikan ke grup middleware "web". Buat sesuatu yang hebat!
|
*/

Route::get('/error-permission', function () {
    return view('errors.permission');
})->name('error.permission');

Route::get('/login', function () {
    return view('login');
})->name('login');

Route::post('/login', [UsersController::class, 'loginAuth'])->name('login.auth');

// RUTE UNTUK LOGIN

Route::get('/logout', [UsersController::class, 'logout'])->name('logout');

Route::get('/register', [UsersController::class, 'createUsers'])->name('register');
Route::post('/store', [UsersController::class, 'storeUsers'])->name('storeUsers');

//ROUTE LOGIN

Route::middleware(['IsLogin'])->group(function () {
    Route::get('/home', function () {
        return view('home');
    })->name('home.page');

   

    Route::middleware(['IsPembimbingSiswa','CheckRoleAndRayon:pembimbing'])->group(function () {
        Route::prefix('/students-ps')->name('students-ps.')->group(function () {
            Route::get('/index', [StudentsController::class, 'indexPs'])->name('index');
            Route::any('/filter', [StudentsController::class, 'filter'])->name('filter');
        });

        Route::prefix('/lates-ps')->name('lates-ps.')->group(function () {
            Route::get('/index', [LatesController::class, 'indexPs'])->name('index');
            Route::any('/filter', [LatesController::class, 'filter'])->name('filter');
            Route::get('/rekap', [LatesController::class, 'rekapPs'])->name('rekap');
            Route::get('/detail/{nis}', [LatesController::class, 'detailPs'])->name('detail');
            Route::get('/download/{id}', [LatesController::class, 'downloadPDF'])->name('download');
            Route::get('/export-excel', [LatesController::class, 'exportExcelPs'])->name('export-excel');
        });
            Route::get('/dashboard-ps', [PembimbingSiswaController::class, 'dashboardPs'])->name('dashboardPs');
        
    });
    

    // LOGIN ADMIN
    Route::middleware(['IsAdmin'])->group(function () {
        //Dashboard
        Route::get('/dashboard', [PembimbingSiswaController::class, 'dashboard'])->name('dashboard');


        // Rayon
        Route::prefix('/rayons')->name('rayons.')->group(function () {
            Route::get('/index', [RayonsController::class, 'index'])->name('index');
            Route::get('/create', [RayonsController::class, 'create'])->name('create');
            Route::post('/store', [RayonsController::class, 'store'])->name('store');
            Route::get('/{id}', [RayonsController::class, 'edit'])->name('edit');
            Route::put('/{id}', [RayonsController::class, 'update'])->name('update');
            Route::delete('/{id}', [RayonsController::class, 'destroy'])->name('destroy');
        });

        // Rombel
        Route::prefix('/rombels')->name('rombels.')->group(function () {
            Route::get('/index', [RombelsController::class, 'index'])->name('index');
            Route::get('/create', [RombelsController::class, 'create'])->name('create');
            Route::post('/store', [RombelsController::class, 'store'])->name('store');
            Route::get('/{id}', [RombelsController::class, 'edit'])->name('edit');
            Route::put('/{id}', [RombelsController::class, 'update'])->name('update');
            Route::any('/filter', [RombelsController::class, 'filter'])->name('filter');
            Route::delete('/{id}', [RombelsController::class, 'destroy'])->name('destroy');
        });

        // Pengguna
        Route::prefix('/users')->name('users.')->group(function () {
            Route::get('/index', [UsersController::class, 'index'])->name('index');
            Route::get('/create', [UsersController::class, 'create'])->name('create');
            Route::post('/store', [UsersController::class, 'store'])->name('store');
            Route::get('/{id}', [UsersController::class, 'edit'])->name('edit');
            Route::put('/{id}', [UsersController::class, 'update'])->name('update');
            Route::delete('/{id}', [UsersController::class, 'destroy'])->name('destroy');
        });

        // Student
        Route::prefix('/students')->name('students.')->group(function () {
            Route::get('/index', [StudentsController::class, 'index'])->name('index');
            Route::get('/create', [StudentsController::class, 'create'])->name('create');
            Route::post('/store', [StudentsController::class, 'store'])->name('store');
            Route::get('/{id}', [StudentsController::class, 'edit'])->name('edit');
            Route::put('/{id}', [StudentsController::class, 'update'])->name('update');
            Route::delete('/{id}', [StudentsController::class, 'destroy'])->name('destroy');
        });

        // Keterlambatan
        Route::prefix('/lates')->name('lates.')->group(function () {
            Route::get('/index', [LatesController::class, 'index'])->name('index');
            Route::get('/rekap', [LatesController::class, 'rekap'])->name('rekap');
            Route::get('/create', [LatesController::class, 'create'])->name('create');
            Route::post('/store', [LatesController::class, 'store'])->name('store');
            Route::get('/detail/{nis}', [LatesController::class, 'detail'])->name('detail');
            // Route::get('/detail', [LatesController::class, 'detail'])->name('detail');
            Route::get('/{id}', [LatesController::class, 'edit'])->name('edit');
            Route::put('/{id}', [LatesController::class, 'update'])->name('update');
            Route::delete('/{id}', [LatesController::class, 'destroy'])->name('destroy');
            Route::get('/download/{id}', [LatesController::class, 'downloadPDF'])->name('download');
        });

        Route::get('/export-excel', [LatesController::class, 'exportExcel'])->name('export-excel');
        
    });
    
});


<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\lates;
use App\Models\users;
use App\Models\rayons;
use App\Models\rombels;
use App\Models\students;
use Illuminate\Http\Request;
// use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class PembimbingSiswaController extends Controller
{
// app/Http/Controllers/PembimbingSiswaController.php

public function dashboard()
{
    // Jumlah Peserta Didik
    $jumlahPesertaDidik = students::count();

    // Jumlah Administrator
    $jumlahAdministrator = users::where('role', 'admin')->count();

    // Jumlah Pembimbing Siswa
    $jumlahPembimbingSiswa = users::where('role', 'ps')->count();

    // Jumlah Rombel
    $jumlahRombel = rombels::count();

    // Jumlah Rayon
    $jumlahRayon = rayons::count();

    return view('dashboard', compact('jumlahPesertaDidik', 'jumlahAdministrator', 'jumlahPembimbingSiswa', 'jumlahRombel', 'jumlahRayon'));
}

public function dashboardPs(Request $request)
{
    setlocale(LC_ALL, 'IND');
    $currentTime = \Carbon\Carbon::now()->formatLocalized('%d %B %Y');

    $rayon = $request->get('rayon');
    $rayonNumber = $request->get('rayonNumber');
    $filter = $request->input('filter');
    $jumlah_data = $request->input('jumlah_data', 10);

    // Retrieve unique rayon values from lates table
    $namaRayon = lates::select('rayon')->distinct()->get();

    // Count the number of students based on the filtered rayon
    $jumlahPesertaDidik = students::whereHas('rayon', function ($query) use ($rayon, $rayonNumber) {
        $query->where('rayon', $rayon . ' ' . $rayonNumber);
    })->count();

    // Count the number of late students based on the filtered rayon and today's date
    $today = Carbon::now()->toDateString();
    $jumlahSiswaTerlambat = lates::where('rayon', $rayon . ' ' . $rayonNumber)
        ->whereDate('created_at', $today)
        ->count();

    return view('dashboard', compact('jumlahPesertaDidik', 'jumlahSiswaTerlambat', 'namaRayon', 'currentTime'));
}


 

}

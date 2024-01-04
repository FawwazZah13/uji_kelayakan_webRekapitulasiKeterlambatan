<?php

namespace App\Http\Controllers;

use PDF;
use Excel;
use App\Models\lates;
use App\Models\students;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use App\Exports\RekapitulasiExportPs;
use App\Exports\RekapitulasiExportFile;

class LatesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Check the user's role
        if (Auth::check() && Auth::user()->role == 'ps') {
            return $this->indexPs($request);
        } else {
            $lates = lates::all();
            return view('lates.index', compact('lates'));
        }
    }

    public function indexPs(Request $request)
    {
        $rayon = $request->get('rayon');
        $rayonNumber = $request->get('rayonNumber');
        $filter = $request->input('filter');
        $jumlah_data = $request->input('jumlah_data', 10);

        // Ambil semua data lates beserta informasi student dan rayon
        $lates = lates::with('rayon')
            ->whereHas('rayon', function ($query) use ($rayon, $rayonNumber) {
                $query->where('rayon', $rayon . ' ' . $rayonNumber);
            })
            ->when($filter, function ($query) use ($filter) {
                $query->where('name', 'like', '%' . $filter . '%');
            })->orderBy('name')->paginate($jumlah_data);

        return view('lates.index', compact('lates'));
    }


    public function create()
    {
        $students = students::all();
        $lates = lates::all();
        return view('lates.create', compact('students','lates'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'nis' => 'required',
            'rombel' => 'required',
            'rayon' => 'required',
            'date_time_late' => 'required|date',
            'information' => 'required',
            'bukti' => 'required|image',
        ], [
            'name.required' => 'Nama harus di isi',
            'nis.required' => 'Nis harus di isi',
            'rombel.required' => 'Rombel harus di isi',
            'rayon.required' => 'Rayon harus di isi',
            'date_time_late.required' => 'Waktu Keterlambatan harus di isi',
            'information.required' => 'Informasi harus di isi',
            'bukti.required' => 'Bukti Keterlambatan harus di isi',
        ]);
    
        $file = $request->file('bukti');
    
        // Ensure a file is present before attempting to store it
        if ($file) {
            // Set the destination path
            $destinationPath = public_path('img');
    
            // Move the file to the desired location
            $file->move($destinationPath, $file->getClientOriginalName());
    
            // Save the file path to the database
            $filePath = 'img/' . $file->getClientOriginalName();
    
            lates::create([
                'name' => $request->name,
                'nis' => $request->nis,
                'rombel' => $request->rombel,
                'rayon' => $request->rayon,
                'date_time_late' => $request->date_time_late,
                'information' => $request->information,
                'bukti' => $filePath,
            ]);
    
            return redirect()->route('lates.index')->with('success', 'Lates successfully created!');
        } else {
            // Handle the case when no file is uploaded
            return redirect()->back()->with('error', 'Please upload a valid image file.');
        }
    }




    /**
     * Display the specified resource.
     */

    public function show($id)
    {
        $lates = lates::find($id);
        return view('lates.print', compact('lates'));
    }



    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $lates = Lates::findOrFail($id);
        return view('lates.edit', compact('lates'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'nis' => 'required',
            'rombel' => 'required',
            'rayon' => 'required',
            'date_time_late' => 'required|date',
            'information' => 'required',
            'bukti' => 'nullable|image',
        ]);
    
        $lates = lates::find($id);
    
        if (!$lates) {
            return redirect()->route('lates.index')->with('error', 'Data tidak ditemukan!');
        }
    
        // Store the current 'bukti' value for comparison later
        $oldBukti = $lates->bukti;
    
        $lates->name = $request->name;
        $lates->nis = $request->nis;
        $lates->rombel = $request->rombel;
        $lates->rayon = $request->rayon;
        $lates->date_time_late = $request->date_time_late;
        $lates->information = $request->information;
    
        if ($request->hasFile('bukti')) {
            // Delete the old 'bukti' file
            if ($oldBukti) {
                $oldFilePath = public_path($oldBukti);
                if (File::exists($oldFilePath)) {
                    File::delete($oldFilePath);
                }
            }
    
            // Set the destination path for 'img' within the 'public' directory
            $imgDestinationPath = public_path('img');
    
            // Move the file to the desired location
            $file = $request->file('bukti');
            $fileExtension = $file->getClientOriginalExtension();
            $fileName = $lates->id . '.' . $fileExtension;
            $file->move($imgDestinationPath, $fileName);
    
            $lates->bukti = 'img/' . $fileName;
        }
    
        $lates->save();
    
        return redirect()->route('lates.index')->with('success', 'Berhasil mengubah data!');
    }
    

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        lates::where('id', $id)->delete();

        return redirect()->back()->with('deleted', 'Berhasil menghapus data!');
    }

    public function rekap()
    {
        $lates = lates::select('name', 'nis', 'rombel', 'rayon')->get();

        $siswa = [];
        foreach ($lates as $item) {
            $nis = $item->nis;

            if (!isset($siswa[$nis])) {
                $siswa[$nis] = [
                    'name' => $item->name,
                    'nis' => $nis,
                    'rombel' => $item->rombel,
                    'rayon' => $item->rayon,
                    'jumlahKeterlambatan' => 0,
                ];
            }

            // Perform logic to calculate the jumlahKeterlambatan for each student
            $siswa[$nis]['jumlahKeterlambatan'] += $this->calculateJumlahKeterlambatan($nis);
        }

        // Convert the associative array back to a numeric array
        $siswa = array_values($siswa);

        return view('lates.rekap', ['siswa' => $siswa]);
    }

    public function rekapPs(Request $request)
    {
        $rayon = $request->get('rayon');
        $rayonNumber = $request->get('rayonNumber');
        $filter = $request->input('filter');
        $jumlah_data = $request->input('jumlah_data', 10);
        $lates = lates::select('name', 'nis', 'rombel', 'rayon')->get();

        $lates = lates::with('rayon')
            ->whereHas('rayon', function ($query) use ($rayon, $rayonNumber) {
                $query->where('rayon', $rayon . ' ' . $rayonNumber);
            })
            ->when($filter, function ($query) use ($filter) {
                $query->where('name', 'like', '%' . $filter . '%');
            })->orderBy('name')->paginate($jumlah_data);

        $siswa = [];
        foreach ($lates as $item) {
            $nis = $item->nis;

            if (!isset($siswa[$nis])) {
                $siswa[$nis] = [
                    'name' => $item->name,
                    'nis' => $nis,
                    'rombel' => $item->rombel,
                    'rayon' => $item->rayon,
                    'jumlahKeterlambatan' => 0,
                ];
            }

            // Increment jumlahKeterlambatan for each student
            $siswa[$nis]['jumlahKeterlambatan']++;
        }

        // Convert the associative array back to a numeric array
        $siswa = array_values($siswa);

        return view('lates.rekap', ['siswa' => $siswa], compact('lates'));
    }

    // Example method to calculate jumlahKeterlambatan for a student
    private function calculateJumlahKeterlambatan($nis)
    {
        // Your logic to calculate jumlahKeterlambatan based on $nis
        // For example, increment jumlahKeterlambatan by 1 for each student with the same nis
        $jumlahKeterlambatan = 1;

        return $jumlahKeterlambatan;
    }


    public function downloadPDF($nis)
    {
        // Ambil data yang diperlukan berdasarkan 'nis'
        $lates = lates::where('nis', $nis)->first();
    
        // Pastikan data berformat array 
        $latesArray = $lates->toArray();
    
        // Tambahkan variabel $currentTime ke dalam array
        $latesArray['currentTime'] = \Carbon\Carbon::now();
    
        // Kirimkan inisial variabel dari data yang akan digunakan pada layout pdf 
        view()->share('lates', $latesArray);
    
        // Panggil blade yang akan di-download 
        $pdf = PDF::loadView('lates.download-pdf', $latesArray);
    
        // Kembalikan atau hasilkan bentuk pdf dengan nama file tertentu 
        return $pdf->download('receipt.pdf');
    }

    public function exportExcel()
    {
        $fileName = 'data.xlsx';
        return Excel::download(new RekapitulasiExportFile, $fileName);
    }
    public function exportExcelPs(Request $request)
    {
        $rayon = $request->get('rayon');
        $rayonNumber = $request->get('rayonNumber');
    
        $fileName = 'data.xlsx';
        return Excel::download(new RekapitulasiExportPs($rayon, $rayonNumber), $fileName);
    }



    public function detail($nis)
    {
        // Fetch the specific student record
        $student = students::where('nis', $nis)->first();

    // Fetch all relevant late records for the student
    $lates = Lates::where('nis', $nis)->get();

    // Process the data to group late records by NIS
    $siswa = [];

    foreach ($lates as $late) {
        $currentNis = $late->nis;

        if (!isset($siswa[$currentNis])) {
            $siswa[$currentNis] = [
                
                'name' => $late->name,
                'rombel' => $late->rombel,
                'rayon' => $late->rayon,
                'nis' => $currentNis,
                'records' => [],
            ];
        }

        // Add the late record to the 'records' array
        $siswa[$currentNis]['records'][] = [
            'date_time_late' => $late->date_time_late,
            'bukti' => $late->bukti,
            'jumlahKeterlambatan' => $this->calculateJumlahKeterlambatan($late),
        ];
    }

    // Pass $student and $siswa to the view
    return view('lates.detail', compact('student', 'siswa'));
    }
public function detailPs($nis)
{
    // Fetch the specific student record
    $student = students::where('nis', $nis)->first();

    // Fetch all relevant late records for the student
    $lates = Lates::where('nis', $nis)->get();

    // Process the data to group late records by NIS
    $siswa = [];

    foreach ($lates as $late) {
        $currentNis = $late->nis;

        if (!isset($siswa[$currentNis])) {
            $siswa[$currentNis] = [
                'name' => $late->name,
                'rombel' => $late->rombel,
                'rayon' => $late->rayon,
                'nis' => $currentNis,
                'records' => [],
            ];
        }

        // Add the late record to the 'records' array
        $siswa[$currentNis]['records'][] = [
            'date_time_late' => $late->date_time_late,
            'bukti' => $late->bukti,
            'jumlahKeterlambatan' => $this->calculateJumlahKeterlambatan($late),
        ];
    }

    // Pass $student and $siswa to the view
    return view('lates.detail', compact('student', 'siswa'));
}

    

    public function filter(Request $request)
    {
        $filter = $request->input('filter');
    
        if ($filter) {
            $lates = lates::where('name', 'like', '%' . $filter . '%')->get();
        } else {
            $lates = lates::all();
        }
    
        return view('lates.index', compact('lates'));
    }

}

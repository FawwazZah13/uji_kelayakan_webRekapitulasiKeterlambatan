<?php

namespace App\Http\Controllers;

use App\Models\rayons;
use App\Models\rombels;
use App\Models\students;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StudentsController extends Controller
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
            $students = students::with(['rombel', 'rayon'])->get();
            return view('students.index', compact('students'));
        }
    }

    
    public function indexPs(Request $request)
    {
        $rayon = $request->get('rayon');
        $rayonNumber = $request->get('rayonNumber');
    
        $filter = $request->input('filter');
        $jumlah_data = $request->input('jumlah_data', 10);
    
        // Menggunakan eager loading untuk memuat relasi 'rayon'
        $students = students::with('rayon')
            ->whereHas('rayon', function ($query) use ($rayon, $rayonNumber) {
                $query->where('rayon', $rayon . ' ' . $rayonNumber);
            })
            ->when($filter, function ($query) use ($filter) {
                $query->where('name', 'like', '%' . $filter . '%');
            })->orderBy('name')->paginate($jumlah_data);
 
            
        return view('students.index', compact('students'));
    }
    

    
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $rombels = rombels::all();
        $rayons = rayons::all();
        $students = students::all();
    
        return view('students.create', compact('rombels', 'rayons', 'students'));
    }
    
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
{
    $request->validate([
        'nis' => 'required',
        'name' => 'required',
        'rayon_id' => 'required',
        'rombel_id' => 'required',
    ]);

    // Use the correct field names 'rayon_id' and 'rombel_id' here
    students::create([
        'nis' => $request->nis,
        'name' => $request->name,
        'rayon_id' => $request->rayon_id,
        'rombel_id' => $request->rombel_id,
    ]);

    return redirect()->route('students.index')->with('success', 'Berhasil Menambahkan Data Siswa!');
}


    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $student = students::findOrFail($id);
        $rayons = $student->rayon;
        $rombels = $student->rombel;

        return view('students.show', compact('student', 'rayons', 'rombels'));
    }
    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
{
    $students = students::findOrFail($id);
    $rombels = rombels::all();
    $rayons = rayons::all();

    return view('students.edit', compact('students', 'rombels', 'rayons'));
}


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'nis' => 'required',
            'name' => 'required',
            'rayon_id' => 'required',
            'rombel_id' => 'required',
        ]);

        $students = students::findOrFail($id);

        // Update password if provided, otherwise keep the existing password
        if ($request->filled('password')) {
            $students->update([
                'nis' => $request->nis,
                'name' => $request->name,
                'rayon_id' => $request->rayon_id,
                'rombel_id' => $request->rombel_id,
            ]);
        } else {
            $students->update([
                'nis' => $request->nis,
                'name' => $request->name,
                'rayon_id' => $request->rayon_id,
                'rombel_id' => $request->rombel_id,
            ]);
        }

        return redirect()->route('students.index')->with('success', 'Berhasil mengubah data!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
       students::where('id', $id)->delete();
    
        return redirect()->back()->with('deleted', 'Berhasil menghapus data!');
    }
public function filter(Request $request)
{
    $filter = $request->input('filter');

    if ($filter) {
        $students = Students::where('name', 'like', '%' . $filter . '%')->get();
    } else {
        $students = Students::all();
    }

    return view('students.index', compact('students'));
}

}

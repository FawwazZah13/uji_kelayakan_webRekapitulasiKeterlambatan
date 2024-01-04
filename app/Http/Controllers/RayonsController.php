<?php

namespace App\Http\Controllers;


use App\Models\users;
use App\Models\rayons;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RayonsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $rayons = rayons::all();
        return view('rayons.index' , compact('rayons'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
    

        $users = users::all();
        return view('rayons.create', compact('users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
{
    $request->validate([
        'rayon' => 'required',
    ]);

    // Create a new rayons instance
    $rayons = new rayons([
        'rayon' => $request->rayon,
        // 'user_id' => $request->user_id,
        'user_id' => Auth::id(),
    ]);

    // Save the rayons instance to the database
    $rayons->save();

    return redirect()->route('rayons.index')->with('success', 'Berhasil Menambahkan Akun!');
}


    


    
    /**
     * Display the specified resource.
     */
    public function show(rayons $rayons)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        // Fetch the record with the given $id and perform necessary operations
        $rayons = rayons::findOrFail($id);
        $users = users::all();
        // Your edit logic here
        return view('rayons.edit', compact('rayons', 'users'));
    }

    /**
     * Update the specified resource in storage.
     */


    public function update(Request $request, $id)
    {
        $request->validate([
            'rayon' => 'required',
        ]);

        rayons::where('id', $id)->update([
            'rayon' => $request->rayon,
        ]);

        return redirect()->route('rayons.index')->with('success', 'Berhasil mengubah data!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $rayons = rayons::find($id);
    
        if (!$rayons) {
            return redirect()->back()->with('error', 'Rayon not found.');
        }
    
        $rayons->delete();
    
        return redirect()->back()->with('deleted', 'Berhasil menghapus data!');
    }
    
}

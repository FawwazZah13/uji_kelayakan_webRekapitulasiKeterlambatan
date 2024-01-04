<?php

namespace App\Http\Controllers;

use App\Models\rombels;
use Illuminate\Http\Request;

class RombelsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $filter = $request->input('filter');
        $jumlah_data = $request->input('jumlah_data', 10); // default 10 jika tidak ada input
    
        if ($filter) {
            $rombels = rombels::where('rombel', 'like', '%' . $filter . '%')->paginate($jumlah_data);
        } else {
            $rombels = rombels::paginate($jumlah_data);
        }
    
        return view('rombels.index', compact('rombels'));
    }
    
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $rombels = rombels::all();
        return view('rombels.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'rombel' => 'required',
        ]);

        // Use the same field name 'rombels' here
        rombels::create([
            'rombel' => $request->rombel,
        ]);

        return redirect()->route('rombels.index')->with('success', 'Berhasil Menambah Rombel!');

    }


    /**
     * Display the specified resource.
     */
    public function show(rombels $rombels)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */

    public function edit($id)
    {
        // Fetch the record with the given $id and perform necessary operations
        $rombels = rombels::findOrFail($id);

        // Your edit logic here
        return view('rombels.edit', compact('rombels'));
    }

    /**
     * Update the specified resource in storage.
     */


    public function update(Request $request, $id)
    {
        $request->validate([
            'rombel' => 'required',
        ]);

        rombels::where('id', $id)->update([
            'rombel' => $request->rombel,
        ]);

        return redirect()->route('rombels.index')->with('success', 'Berhasil mengubah data!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        rombels::where('id', $id)->delete();

        return redirect()->back()->with('deleted', 'Berhasil menghapus data!');
    }

    public function filter(Request $request)
    {
        $filter = $request->input('filter');

        if ($filter) {
            $rombels = rombels::where('rombel', 'like', '%' . $filter . '%')->get();
        } else {
            $rombels = [];
        }

        return view('rombels.index', compact('rombels'));
    }
}


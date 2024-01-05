<?php

namespace App\Http\Controllers;

use App\Models\users;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = users::all();
        return view('users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        
        $users = users::all();
        return view('users.create', compact('users'));
    }
    public function createUsers()
    {
        
        $users = users::all();
        return view('register', compact('users'));
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
{
    $request->validate([
        'name' => 'required',
        'email' => 'required|email',
        'role' => 'required',
    ]);

    $password = Str::slug(Str::words($request->name, 3, '')) . Str::slug(Str::words($request->email, 3, ''));

    users::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => Hash::make($password),
        'role' => $request->role,
    ]);

    return redirect()->route('users.index')->with('success', 'User successfully created!');
}

public function storeUsers(Request $request)
{
    $request->validate([
        'name' => 'required',
        'email' => 'required|email',
        'role' => 'required',
    ]);


    users::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' =>Hash::make($request->password),
        'role' => $request->role,
    ]);

    return redirect()->route('login')->with('success', 'User successfully created!');
}



    /**
     * Display the specified resource.
     */
    public function show(users $users)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        // Fetch the record with the given $id and perform necessary operations
        $users = users::findOrFail($id);

        // Your edit logic here
        return view('users.edit', compact('users'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required',
            'role' => 'required',
        ]);

        $users = users::findOrFail($id);

        // Update password if provided, otherwise keep the existing password
        if ($request->filled('password')) {
            $users->update([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => $request->role,
            ]);
        } else {
            $users->update([
                'name' => $request->name,
                'email' => $request->email,
                'role' => $request->role,
            ]);
        }

        return redirect()->route('users.index')->with('success', 'Berhasil mengubah data!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $users = users::find($id);
    
        if (!$users) {
            return redirect()->route('users.index')->with('deleted', 'Pengguna tidak ditemukan.');
        }
    
        $users->delete();
    
        return redirect()->route('users.index')->with('deleted', 'Pengguna berhasil dihapus.');
    }

    //LOGIN 
    public function loginAuth(Request $request)
    {
        $request->validate([
            'email' => 'required|email:dns',
            'password' => 'required|alpha_dash',
        ], [
            'email.required' => 'Email harus diisi',
            'email.email' => 'Email tidak valid',
            'password.required' => 'Password harus diisi',
            'password.alpha_dash' => 'Password harus berisi huruf dan karakter tanpa spasi'
        ]);
    
        $user = $request->only(['email', 'password']);
        if (Auth::attempt($user)) {
            // Retrieve additional user data, assuming you have a 'rayon' and 'rayonNumber' field in your user model
            $userData = Auth::user();
    
            // Set the session data
            Session::put('rayon', $userData->rayon);
            Session::put('rayonNumber', $userData->rayonNumber);
    
            return redirect()->route('home.page')->with('success', 'Login successful!');
        } else {
            return redirect()->back()->with('failed', 'Proses login gagal, silahkan coba kembali dengan data yang benar!');
        }
    }
    public function logout(){
        Auth::logout();
        return redirect()->route('login')->with('logout', 'Anda telah logout!');
    }
    
}

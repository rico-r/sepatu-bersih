<?php

namespace App\Http\Controllers;

use App\Models\Karyawan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class KaryawanController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:karyawan');
    }
    
    public function dashboard()
    {
        return view('karyawan.dashboard');
    }
    
    public function view()
    {
        return view('karyawan.data');
    }

    public function tambah()
    {
        return view('karyawan.tambah');
    }

    public function store(Request $request)
    {
        $karyawan = new Karyawan();
        $karyawan->username = $request->username;
        $karyawan->nama = $request->name;
        $karyawan->password = Hash::make($request->password);
        $karyawan->role = $request->role;
        $karyawan->save();
        session()->flash('message', 'Data karyawan berhasil ditambahkan.');
        return redirect(route('karyawan.view'));
    }

    public function edit(Karyawan $karyawan)
    {
        return view('karyawan.edit', ['data' => $karyawan]);
    }

    public function update(Request $request, Karyawan $karyawan)
    {
        $attr = $request->only(['nama', 'username', 'role']);
        if($request->has('password')) {
            $attr['password'] = Hash::make($request->password);
        }
        $karyawan->update($attr);
        session()->flash('message', 'Data karyawan berhasil diedit.');
        return redirect(route('karyawan.view'));
    }

    public function deactivate(Karyawan $karyawan)
    {
        $karyawan->update(['active' => 0]);
        session()->flash('message', 'Karyawan berhasil dinon-aktifkan.');
        return redirect(route('karyawan.view'));
    }

    public function activate(Karyawan $karyawan)
    {
        $karyawan->update(['active' => 1]);
        session()->flash('message', 'Karyawan berhasil diaktifkan.');
        return redirect(route('karyawan.view'));
    }
}

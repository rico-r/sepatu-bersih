<?php

namespace App\Http\Controllers;

use App\Models\Layanan;
use Illuminate\Http\Request;

class LayananController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:karyawan');
        $this->middleware('can:edit-service')->except('all');
    }

    public function view()
    {
        return view('layanan.view');
    }

    public function tambah()
    {
        return view('layanan.tambah');
    }

    public function edit(Layanan $layanan)
    {
        return view('layanan.edit', ['layanan' => $layanan]);
    }

    public function store(Request $request)
    {
        $layanan = new Layanan($request->only(['nama', 'harga']));
        $layanan->save();
        session()->flash('message', 'Layanan berhasil ditambahkan.');
        return redirect(route('layanan.view'));
    }

    public function update(Request $request, Layanan $layanan)
    {
        $layanan->update($request->only(['nama', 'harga']));
        session()->flash('message', 'Layanan berhasil diedit.');
        return redirect(route('layanan.view'));
    }

    public function delete(Request $request, Layanan $layanan)
    {
        $layanan->delete();
        session()->flash('message', 'Layanan berhasil dihapus.');
        return redirect(route('layanan.view'));
    }
}

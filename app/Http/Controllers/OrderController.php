<?php

namespace App\Http\Controllers;

use App\Models\Pesanan;
use App\Models\RincianPesanan;
use App\Models\StatusPesanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class OrderController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:karyawan');
    }

    function makeOrderView()
    {
        return view('karyawan.make-order');
    }

    function view(Pesanan $pesanan)
    {
        return view('karyawan.view-order', [
            'pesanan' => $pesanan,
        ]);
    }

    function all()
    {
        return view('karyawan.all-order', [
            'listPesanan' => Pesanan::all(),
        ]);
    }

    function saveOrder(Request $request)
    {
        Log::debug('save order', $request->all());
        $order = Pesanan::create([
            'id_kasir' => $request['kasir'],
            'uang' => $request['uang'],
            'kembalian' => $request['kembalian'],
        ]);
        Log::debug('order', [$order]);
        foreach ($request['list'] as $layanan) {
            RincianPesanan::create([
                'id_pesanan' => $order['id'],
                'id_layanan' => $layanan['id'],
                'jumlah' => $layanan['jumlah'],
                'harga' => $layanan['harga'],
            ]);
        }
        return [
            'success' => true
        ];
    }

    function  listProcess()
    {
        return view('karyawan.order-processing', [
            'listPesanan' => Pesanan::where('status', 'process')->get(),
        ]);
    }

    function  listReady()
    {
        return view('karyawan.order-ready', [
            'listPesanan' => Pesanan::where('status', 'ready')->get(),
        ]);
    }

    function markReady(Pesanan $pesanan)
    {
        StatusPesanan::create([
            'id_pesanan' => $pesanan->id,
            'status' => 'ready',
        ]);
        return [
            'success' => true,
        ];
    }

    function delete(Pesanan $pesanan)
    {
        $pesanan->delete();
        return [
            'status' => true,
        ];
    }
}

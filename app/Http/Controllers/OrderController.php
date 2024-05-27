<?php

namespace App\Http\Controllers;

use App\Models\Pesanan;
use App\Models\RincianPesanan;
use App\Models\StatusPesanan;
use Illuminate\Http\Request;
use Symfony\Contracts\Service\Attribute\Required;

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

    function getJson(Pesanan $pesanan)
    {
        // return Pesanan::with('rincian')->find($pesanan->id);
        $semua_rincian = [];
        foreach ($pesanan->rincian->all() as $rincian) {
            array_push($semua_rincian, [
                'nama' => $rincian->layanan->first()->nama,
                'jumlah' => $rincian->jumlah,
                'harga' => $rincian->harga,
                'subtotal' => $rincian->subtotal,
            ]);
        }
        return [
            'id' => $pesanan->id,
            'kasir' => $pesanan->kasir->first()->nama,
            'total' => $pesanan->total,
            'uang' => $pesanan->uang,
            'kembalian' => $pesanan->kembalian,
            'tgl' => $pesanan->created_at,
            'rincian' => $semua_rincian,
        ];
        // return $pesanan->with('rincian')->get();
    }

    function all()
    {
        return view('karyawan.all-order', [
            'listPesanan' => Pesanan::all(),
        ]);
    }

    function saveOrder(Request $request)
    {
        $order = Pesanan::create([
            'id_kasir' => $request['kasir'],
            'uang' => $request['uang'],
            'kembalian' => $request['kembalian'],
        ]);
        foreach ($request['list'] as $layanan) {
            RincianPesanan::create([
                'id_pesanan' => $order['id'],
                'id_layanan' => $layanan['id'],
                'jumlah' => $layanan['jumlah'],
                'harga' => $layanan['harga'],
            ]);
        }
        return [
            'success' => true,
            'id' => $order->id
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

    function  listDone()
    {
        return view('karyawan.order-done', [
            'listPesanan' => Pesanan::where('status', 'done')
                ->with('detail_status')
                ->get(),
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

    function revertReady(Pesanan $pesanan)
    {
        // StatusPesanan::where('id_pesanan', '=', $pesanan->id)
        //     ->where('status', '=', 'ready')
        //     ->first()
        //     ->delete();
        return [
            'success' => true,
        ];
    }

    function revertDone(Pesanan $pesanan)
    {
        $pesanan->detail_status
            ->where('status', 'done')
            ->first()
            ->delete();
        return [
            'success' => true,
        ];
    }

    function markDone(Pesanan $pesanan)
    {
        StatusPesanan::create([
            'id_pesanan' => $pesanan->id,
            'status' => 'done',
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

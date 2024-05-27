<?php

namespace App\Http\Controllers;

use App\Models\Pesanan;
use App\Models\RincianPesanan;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:karyawan');
        $this->middleware('can:manage-web');
    }

    function getMonthRevenue(Request $request)
    {
        // $startDate = Carbon::now()->addDays(-30)->startOfDay();
        // $endDate = Carbon::now();
        $startDate = Carbon::parse($request['start']);
        $endDate = Carbon::parse($request['end'])->addDay()->startOfDay();

        return Pesanan::whereBetween('created_at', [$startDate, $endDate])
            ->selectRaw('DATE(created_at) as date, SUM(total) as total')
            ->groupBy('date')
            ->orderBy('date')
            ->get();
    }

    function getServiceTypeCount(Request $request)
    {
        // $startDate = Carbon::now()->addDays(-30)->startOfDay();
        // $endDate = Carbon::now();
        $startDate = Carbon::parse($request['start']);
        $endDate = Carbon::parse($request['end'])->addDay()->startOfDay();

        return DB::table('rincian_pesanan')
            ->join('layanan', 'rincian_pesanan.id_layanan', '=', 'layanan.id')
            ->select('layanan.nama', DB::raw('SUM(rincian_pesanan.jumlah) as jumlah'))
            ->whereBetween('rincian_pesanan.created_at', [$startDate, $endDate])
            ->groupBy('layanan.nama')
            ->get();
    }

    function getReportContent(Request $request)
    {
        $startDate = Carbon::parse($request['start']);
        $endDate = Carbon::parse($request['end'])->addDay()->startOfDay();
        // return RincianPesanan::whereBetween('created_at', [$startDate, $endDate])
        //     ->get();
        return DB::table('rincian_pesanan')
            ->join('layanan', 'rincian_pesanan.id_layanan', '=', 'layanan.id')
            ->select('layanan.nama', 'rincian_pesanan.jumlah', 'rincian_pesanan.harga', 'rincian_pesanan.subtotal', DB::raw('rincian_pesanan.created_at AS date'))
            ->whereBetween('rincian_pesanan.created_at', [$startDate, $endDate])
            ->orderBy('rincian_pesanan.created_at')
            ->get();
    }
}

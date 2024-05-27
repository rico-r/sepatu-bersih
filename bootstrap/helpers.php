<?php

use App\Models\Pesanan;
use Illuminate\Support\Carbon;

function formatDate($dateString, $format = 'Y-m-d')
{
    $date = new DateTime($dateString);
    return $date->format($format);
}

function formatMoney($amount)
{
    return 'Rp. ' . number_format($amount, 2, ',', '.');
}

function formatDatetime($datetime)
{
    return date('H:i:s d-m-Y', strtotime($datetime));
}


function getMonthRevenue()
{
    $startDate = Carbon::today()->addDays(-30)->startOfDay();
    $endDate = Carbon::today();

    $totalAmount = Pesanan::whereBetween('created_at', [$startDate, $endDate])->sum('total');
    return $totalAmount;
}

function getTodayRevenue()
{
    $endDate = Carbon::now();
    $startDate = Carbon::now()->startOfDay();

    return Pesanan::whereBetween('created_at', [$startDate, $endDate])->sum('total');;
}

function getMonthCustomer()
{
    $startDate = Carbon::now()->addDays(-30)->startOfDay();
    $endDate = Carbon::now();

    return Pesanan::whereBetween('created_at', [$startDate, $endDate])->count();
}

function getTodayCustomer()
{
    $endDate = Carbon::now();
    $startDate = Carbon::now()->startOfDay();

    return Pesanan::whereBetween('created_at', [$startDate, $endDate])->count();
}

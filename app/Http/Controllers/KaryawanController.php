<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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
    
    public function viewDataKaryawan()
    {
        return view('karyawan.data');
    }
}

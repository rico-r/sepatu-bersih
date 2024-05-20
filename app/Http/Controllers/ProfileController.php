<?php

namespace App\Http\Controllers;

use App\Models\Karyawan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class ProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:karyawan');
    }

    public function redirect()
    {
        $guard = Auth::guard('karyawan');
        if ($guard->user()->role == 'admin') {
            return redirect(route('admin.dashboard'));
        } else {
            return redirect(route('order.make'));
        }
    }

    public function profile()
    {
        return view('karyawan.profile');
    }

    public function updateProfile(Request $request)
    {
        $userAuth = Auth::guard('karyawan')->user();
        $request->validate([
            'username' => 'unique:karyawan,username,' . $userAuth->id,
        ]);
        $user = Karyawan::find($userAuth->id);
        $attr = $request->only(['nama', 'username']);
        Log::debug('update profile', $request->all());
        if ($request->has('password') && strlen($request->password) > 0) {
            $attr['password'] = Hash::make($request->password);
        }
        $user->update($attr);
        session()->flash('message', 'Profil berhasil disimpan.');
        return redirect(route('karyawan.profile'));
    }
}

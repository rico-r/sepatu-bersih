@extends('layout.dashboard-karyawan')

@section('title', 'Tambah Data Karyawan')

@section('content')

<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Tambah Data Karyawan</h1>
</div>

<!-- DataTales Example -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Tambah Data Karyawan</h6>
    </div>
    <div class="card-body">
        <div class="container">
            <form id="form" method="post" action="{{ route('karyawan.store') }}">
                @csrf
                <div class="form-group">
                    <label for="name">Nama:</label>
                    <input type="text" class="form-control form-control-user"
                        id="name" name="name" autocomplete="off"
                        placeholder="Nama" required>
                </div>
                <div class="form-group">
                    <label for="username">Username:</label>
                    <input type="text" class="form-control form-control-user"
                        id="username" name="username" autocomplete="off"
                        placeholder="Username" required>
                </div>
                <div class="form-group">
                    <label for="password">Password:</label>
                    <input type="password" class="form-control form-control-user"
                        id="password" name="password" autocomplete="off"
                        placeholder="Password" required>
                </div>
                <div class="form-group">
                    <label for="password">Role:</label>
                    <select class="form-control form-control-user" style="width: 100%" name="role" id="role" required >
                        <option value="karyawan">karyawan</option>
                        <option value="admin">admin</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary btn-user btn-block">
                    Simpan
                </button >
            </form>
        </div>
    </div>
</div>

@endsection

@push('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" />
@endpush

@extends('layout.dashboard-karyawan')

@section('title', 'Edit Layanan')

@section('content')

<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Edit Layanan</h1>
</div>

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Edit Layanan</h6>
    </div>
    <div class="card-body">
        <div class="container">
            <form id="form" method="post" action="{{ route('layanan.update', ['layanan'=>$layanan]) }}">
                @csrf
                <div class="form-group">
                    <label for="name">Nama:</label>
                    <input type="text" class="form-control form-control-user"
                        id="name" name="nama" autocomplete="off" value="{{ old('nama', $layanan->nama) }}"
                        placeholder="Nama" required>
                </div>
                <div class="form-group">
                    <label for="harga">Harga:</label>
                    <input type="number" class="form-control form-control-user"
                        id="harga" name="harga" autocomplete="off" value="{{ old('harga', $layanan->harga) }}"
                        placeholder="harga" required>
                </div>
                <button type="submit" class="btn btn-primary btn-user btn-block">
                    Simpan
                </button >
            </form>
        </div>
    </div>
</div>

@endsection

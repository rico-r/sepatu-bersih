@extends('layout.dashboard-karyawan')

@section('title', 'Daftar Pesanan Diproses')

@section('content')
<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Profile</h1>
</div>

<div class="row">
    <div class="mb-4">
        <div class="card shadow pe-2">
            <div class="card-body">
                <form id="form" method="post" action="{{ route('karyawan.update-profile') }}">
                    @csrf
                    <div class="form-group">
                        <label for="nama">Nama:</label>
                        <input type="text" class="form-control form-control-user"
                            id="nama" name="nama" autocomplete="off" value="{{ old('nama', $user->nama) }}"
                            placeholder="Nama" required>
                    </div>
                    <div class="form-group">
                        <label for="username">Username:</label>
                        <input type="text" class="form-control form-control-user"
                            id="username" name="username" autocomplete="off"  value="{{ old('username', $user->username) }}"
                            placeholder="Username" required>
                    </div>
                    <div class="form-group">
                        <label for="password">Password:</label>
                        <input type="password" class="form-control form-control-user"
                            id="password" name="password" autocomplete="off"
                            placeholder="Password">
                    </div>
                    @include('layout.error-container', ['field' => 'username'])
                    <button type="submit" class="btn btn-primary btn-user btn-block">
                        Simpan
                    </button >
                </form>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
@endpush

@extends('layout.dashboard-karyawan')

@section('title', 'Edit Data Karyawan')

@section('content')

<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Edit Data Karyawan</h1>
</div>

<!-- DataTales Example -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Edit Data Karyawan</h6>
    </div>
    <div class="card-body">
        <div class="container">
            <form id="form" method="post" action="{{ route('karyawan.update', ['karyawan'=>$data->id]) }}">
                @csrf
                <div class="form-group">
                    <label for="nama">Nama:</label>
                    <input type="text" class="form-control form-control-user"
                        id="nama" name="nama" autocomplete="off" value="{{ old('nama', $data->nama) }}"
                        placeholder="Nama" required>
                </div>
                <div class="form-group">
                    <label for="username">Username:</label>
                    <input type="text" class="form-control form-control-user"
                        id="username" name="username" autocomplete="off"  value="{{ old('username', $data->username) }}"
                        placeholder="Username" required>
                </div>
                <div class="form-group">
                    <label for="password">Password:</label>
                    <input type="password" class="form-control form-control-user"
                        id="password" name="password" autocomplete="off"
                        placeholder="Password">
                </div>
                <div class="form-group">
                    <label for="role">Role:</label>
                    <x-select class="form-control form-control-user w-100" name="role" id="role"
                        :disable-if="$user->id == $data->id"
                        :value="['karyawan', 'admin']" :default="old('role', $data->role)" required/>
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
{{-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" /> --}}
@endpush

@push('scripts')
{{-- <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script> --}}

{{-- <script>
$(document).ready(function() {
  $('#role').select2();
});
</script> --}}
@endpush
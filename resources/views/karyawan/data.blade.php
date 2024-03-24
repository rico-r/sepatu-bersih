@extends('layout.dashboard-karyawan')

@section('title', 'Data Karyawan')

@section('content')

<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Data Karyawan</h1>
</div>

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Data Karyawan Aktif</h6>
    </div>
    <div class="card-body">
        <a class="btn btn-primary mb-3 w-100" href="{{ route('karyawan.tambah') }}">
            <i class="fa fa-plus-square"></i>
            Tambah Karyawan
        </a>
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Nama</th>
                        <th>Username</th>
                        <th>role</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                @foreach (\App\Models\Karyawan::where('active', '1')->get() as $karyawan)
                    <tr>
                        <td>{{ $karyawan->nama }}</td>
                        <td>{{ $karyawan->username }}</td>
                        <td>{{ $karyawan->role }}</td>
                        <td>
                            <a href="{{ route('karyawan.edit', ['karyawan' => $karyawan]) }}" class="btn btn-primary">
                                <i class="fa fa-pencil-alt mr-md-2"></i>
                                <span class="d-none d-md-inline-block">Edit</span>
                            </a>
                            @if($user->id != $karyawan->id)
                            <form method="post" class="d-inline-block" action="{{ route('karyawan.deactivate', ['karyawan' => $karyawan]) }}">
                                @csrf
                                <button type="submit" class="btn btn-danger">
                                    <i class="fa fa-user-slash mr-md-2"></i>
                                    <span class="d-none d-md-inline-block">Non-aktifkan</span>
                                </button>
                            </form>
                            @endif
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Data Karyawan Non-Aktif</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Nama</th>
                        <th>Username</th>
                        <th>role</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                @foreach (\App\Models\Karyawan::where('active', 0)->get() as $karyawan)
                    <tr>
                        <td>{{ $karyawan->nama }}</td>
                        <td>{{ $karyawan->username }}</td>
                        <td>{{ $karyawan->role }}</td>
                        <td>
                            <form method="post" class="d-inline-block" action="{{ route('karyawan.activate', ['karyawan' => $karyawan]) }}">
                                @csrf
                                <button class="btn btn-primary">
                                    <i class="fa fa-user mr-md-2"></i>
                                    <span class="d-none d-md-inline-block">Aktifkan</span>
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection

@push('styles')
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.24/css/dataTables.bootstrap4.min.css">
@endpush

@push('scripts')
<script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.24/js/dataTables.bootstrap4.min.js"></script>

<script>
$(document).ready(function() {
  $('#dataTable').DataTable();
});
</script>

@endpush
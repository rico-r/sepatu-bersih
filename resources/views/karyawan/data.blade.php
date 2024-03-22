@extends('layout.dashboard-karyawan')

@section('title', 'Data Karyawan')

@section('content')

<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Data Karyawan</h1>
</div>

<!-- DataTales Example -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Data Karyawan</h6>
    </div>
    <div class="card-body">
        <a class="btn btn-primary mb-3 w-100" data-toggle="modal" data-target="#insertModal">
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
                <tfoot>
                    <tr>
                        <th>Nama</th>
                        <th>Username</th>
                        <th>role</th>
                        <th>Aksi</th>
                    </tr>
                </tfoot>
                <tbody>
                @foreach (\App\Models\Karyawan::all() as $karyawan)
                    <tr>
                        <td>{{ $karyawan->nama }}</td>
                        <td>{{ $karyawan->username }}</td>
                        <td>{{ $karyawan->role }}</td>
                        <td>
                            <button class="btn btn-primary">
                                <i class="fa fa-pencil-alt mr-md-2"></i>
                                <span class="d-none d-md-inline-block">Edit</span>
                            </button>
                            @if($user->id != $karyawan->id)
                            <button class="btn btn-danger">
                                <i class="fa fa-trash-alt mr-md-2"></i>
                                <span class="d-none d-md-inline-block">Hapus</span>
                            </button>
                            @endif
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Tambah karyawan -->
<div class="modal fade" id="insertModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah data karyawan</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="container">
                <form>
                    <div class="form-group">
                        <label for="username">Username:</label>
                        <input type="text" class="form-control form-control-user"
                            id="username" name="username"
                            placeholder="Username" required>
                    </div>
                    <div class="form-group">
                        <label for="password">Password:</label>
                        <input type="text" class="form-control form-control-user"
                            id="password" name="password"
                            placeholder="Password (Isi jika ingin mengganti password)" required>
                    </div>
                    <div class="form-group">
                        <label for="password">Role:</label>
                        <datalist id="roles">
                            <option>admin</option>
                            <option>karyawan</option>
                        </datalist>
                        <input type="text" autoComplete="on" list="roles"/>
                        {{-- <select name="role" id="role" >
                            <option value="admin">admin</option>
                            <option value="karyawan">karyawan</option>
                        </select> --}}
                    </div>
                    <button type="submit" class="btn btn-primary btn-user btn-block">
                        Simpan
                    </button >
                </form>
                </div>
            </div>
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
// Call the dataTables jQuery plugin
$(document).ready(function() {
  $('#dataTable').DataTable();
});
</script>

@endpush
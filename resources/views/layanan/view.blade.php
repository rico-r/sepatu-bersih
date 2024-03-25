@extends('layout.dashboard-karyawan')

@section('title', 'Data Layanan')

@section('content')

<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Data Layanan</h1>
</div>

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Data Layanan</h6>
    </div>
    <div class="card-body">
        <a class="btn btn-primary mb-3 w-100" href="{{ route('layanan.tambah') }}">
            <i class="fa fa-plus-square"></i>
            Tambah Layanan
        </a>
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Nama</th>
                        <th>Harga</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                @foreach (\App\Models\Layanan::all() as $layanan)
                    <tr>
                        <td>{{ $layanan->nama }}</td>
                        <td>{{ formatMoney($layanan->harga) }}</td>
                        <td>
                            <a href="{{ route('layanan.edit', ['layanan' => $layanan]) }}" class="btn btn-primary">
                                <i class="fa fa-pencil-alt mr-md-2"></i>
                                <span class="d-none d-md-inline-block">Edit</span>
                            </a>
                            <button type="submit" class="btn btn-danger" onclick="hapus('{{ $layanan->nama }}', '{{ route('layanan.delete', ['layanan' => $layanan]) }}')">
                                <i class="fa fa-trash-alt mr-md-2"></i>
                                <span class="d-none d-md-inline-block">Hapus</span>
                            </button>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>


<!-- Delete Modal-->
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Konfirmasi hapus</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body"></div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" type="button" data-dismiss="modal">Batal</button>
                <form class="d-inline-block" method="post">
                    @csrf
                    @method('delete')
                    <button type="submit" class="btn btn-danger">Hapus</button>
                </form>
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
$(document).ready(function() {
  $('table').DataTable();
});

function hapus(nama, url) {
    $("#deleteModal form").attr('action', url)
    $("#deleteModal .modal-body").text('Anda yakin ingin menghapus layanan "'+nama+'"?');
    new bootstrap.Modal(document.getElementById("deleteModal")).show();

}
</script>

@endpush
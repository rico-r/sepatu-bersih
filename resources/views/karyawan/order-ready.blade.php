@extends('layout.dashboard-karyawan')

@section('title', 'Daftar Pesanan Diproses')

@section('content')
<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Daftar Pesanan Selesai</h1>
</div>

<div class="row">
    <div class="mb-4">
        <div class="card shadow pe-2">
            <div class="card-body">
                <form id="search">
                    <div class="input-group">
                        <input name="keyword" type="text" class="form-control bg-light small" placeholder="Cari ID pesanan..." autocomplete="off" title="Shortcut: / (SLASH)" autofocus>
                        <div class="input-group-append">
                            <button class="btn btn-primary">
                                <i class="fas fa-search fa-sm"></i>
                            </button>
                        </div>
                    </div>
                </form>

                <div class="table-responsive mt-2">
                    <table class="table table-bordered" id="dataPesanan" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>ID Pesanan</th>
                                <th>Total</th>
                                <th>Waktu Pesan</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach ($listPesanan as $pesanan)
                            <tr>
                                <td>{{ $pesanan->id }}</td>
                                <td>{{ formatMoney($pesanan->total) }}</td>
                                <td>{{ formatDatetime($pesanan->created_at) }}</td>
                                <td>
                                    <button class="btn btn-success" title="Tandai diambil" onclick="mark(this, {{ $pesanan->id }})">
                                        <i class="fa fa-check"></i>
                                    </button>
                                    <a class="btn btn-primary" title="Lihat pesanan" href="{{ route('order.view', ['pesanan' => $pesanan->id] )}}">
                                        <i class="fa fa-eye"></i>
                                    </a>
                                    <button class="btn btn-danger" title="Hapus pesanan" onclick="deleteOrder(this, {{ $pesanan->id }})">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
const ROUTE_MARK_READY = '{{ route('order.mark-ready', ['pesanan' => '##']) }}';
const ROUTE_MARK_DONE = '{{ route('order.mark-done', ['pesanan' => '##']) }}';
const ROUTE_DELETE = '{{ route('order.delete', ['pesanan' => '##']) }}';
</script>

<script src="/js/order.js"></script>
@endpush

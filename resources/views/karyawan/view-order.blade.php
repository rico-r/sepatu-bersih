@extends('layout.dashboard-karyawan')

@section('title', 'Pesanan '.$pesanan->id)

@section('content')
<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Rincian Pesanan {{ $pesanan->id }}</h1>
</div>

<div class="row">
    <div class="mb-4">
        <div class="card shadow pe-2">
            <div class="card-body">
                {{-- <form id="search">
                    <div class="input-group">
                        <input name="keyword" type="text" class="form-control bg-light small" placeholder="Cari ID pesanan..." autocomplete="off" title="Shortcut: / (SLASH)" autofocus>
                        <div class="input-group-append">
                            <button class="btn btn-primary">
                                <i class="fas fa-search fa-sm"></i>
                            </button>
                        </div>
                    </div>
                </form> --}}

                <div class="table-responsive mt-2">

                    <table class="table table-borderless" cellspacing="0" cellpadding="0">
                        <tr>
                            <td>Tanggal</td>
                            <td>:</td>
                            <td class="text-right">{{ formatDatetime($pesanan->created_at) }}</td>
                        </tr>
                        <tr>
                            <td>Kasir</td>
                            <td>:</td>
                            <td class="text-right">{{ $pesanan->kasir->nama }}</td>
                        </tr>
                        <tr>
                            <td>Status</td>
                            <td>:</td>
                            <td class="text-right fw-bold">{{ $pesanan->status_view() }}</td>
                        </tr>
                    </table>

                    <table class="table table-bordered" cellspacing="0" cellpadding="0">
                        <thead>
                            <tr>
                                <th>Layanan</th>
                                <th>Harga</th>
                                <th>Jumlah</th>
                                <th>Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($pesanan->rincian as $rincian)
                            <tr>
                                <td>{{ $rincian->layanan->nama }}</td>
                                <td class="text-right">{{ formatMoney($rincian->harga) }}</td>
                                <td>{{ $rincian->jumlah }}</td>
                                <td class="text-right">{{ formatMoney($rincian->subtotal) }}</td>
                            </tr>
                            @endforeach
                            <tr>
                                <td class="fw-bold" colspan=3>Total</td>
                                <td id="value" class="text-right">{{ formatMoney($pesanan->total) }}</td>
                            </tr>
                            <tr>
                                <td class="fw-bold" colspan=3>Uang</td>
                                <td id="value" class="text-right">{{ formatMoney($pesanan->uang) }}</td>
                            </tr>
                            <tr>
                                <td class="fw-bold" colspan=3>Kembalian</td>
                                <td id="value" class="text-right">{{ formatMoney($pesanan->kembalian) }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

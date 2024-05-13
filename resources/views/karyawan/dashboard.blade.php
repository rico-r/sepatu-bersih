@extends('layout.dashboard-karyawan')

@section('title', 'Dashboard Karyawan')

@section('content')
<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Kasir</h1>
</div>

<div class="row">
    <div class="mb-4 col-md-6">
        <div class="card shadow pe-2">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Layanan</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataLayanan" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Layanan</th>
                                <th>Harga</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td id="nama"></td>
                                <td id="harga"></td>
                                <td>
                                    <button id="minus" class="btn btn-primary p-1">
                                        <i class="fa fa-minus fa-sm"></i>
                                    </button>
                                    <input id="amount" type="number" width="0px">
                                    <button id="plus" class="btn btn-primary p-1">
                                        <i class="fa fa-plus fa-sm"></i>
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="card shadow mb-4 col-md-6">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Nota</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table id="nota" class="table table-bordered" cellspacing="0" cellpadding="0">
                    <thead>
                        <tr>
                            <th>Layanan</th>
                            <th>Harga</th>
                            <th>Jumlah</th>
                            <th>Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr id="row">
                            <td id="nama"></td>
                            <td id="harga" class="text-right"></td>
                            <td id="jumlah"></td>
                            <td id="subtotal" class="text-right"></td>
                        </tr>
                        <tr id="total">
                            <td class="fw-bold" colspan=3>Total</td>
                            <td id="value" class="text-right"></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@endsection

@push('styles')
    <link rel="stylesheet" href="/css/dashboard.css">
@endpush

@push('scripts')
    <!-- Page level plugins -->
<script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.24/js/dataTables.bootstrap4.min.js"></script>

<script>
{{-- $(document).ready(function() {
}); --}}

function formatMoney(amount) {
    const result = [];
    amount = amount.toString();
    while(amount.length > 3) {
        const len = amount.length;
        result.unshift(amount.substring(len, len - 3));
        amount = amount.substring(0, len - 3);
    }
    result.unshift(amount);
    return 'Rp. ' + result.join('.') + ',00';
}

const dataLayanan = @json(\App\Models\Layanan::all());
const nota = [];

const recalculate = (function() {
    const tbody = $('#nota > tbody');
    const rowEl = tbody.find('#row');
    const totalEl = tbody.find('#total');
    return () => {
        tbody.children().remove();
        let total = 0;
        dataLayanan.forEach(data => {
            console.log(data.nama, '=', data.jumlah)
            if(data.jumlah == 0) return;
            const subtotal = data.harga * data.jumlah;
            const row = rowEl.clone(true);
            total += subtotal;
            row.find('#nama').text(data.nama);
            row.find('#harga').text(formatMoney(data.harga));
            row.find('#jumlah').text(data.jumlah);
            row.find('#subtotal').text(formatMoney(subtotal));
            tbody.append(row);
        })
        totalEl.find('#value').text(formatMoney(total))
        tbody.append(totalEl);
    };
})();

$(document).ready(function() {
  const tbody = $('#dataLayanan > tbody');
  const template = $('#dataLayanan > tbody > tr');
  template.remove();
  dataLayanan.forEach((data) => {
    const layanan = template.clone(true);
    const amount = layanan.find('#amount');
    data.jumlah = 0;

    function setAmount(x, update = true) {
        x = parseInt(x);
        if(x < 0 || isNaN(x)) x = data.jumlah;
        data.jumlah = x;
        if(update) {
            amount.val(data.jumlah);
        }
        recalculate();
        {{-- console.log(data.nama, '=', data.jumlah) --}}
    }

    layanan.find('#nama').text(data.nama);
    layanan.find('#harga').text(formatMoney(data.harga));
    amount.val(0);
    layanan.find('#plus').on('click', (e) => {
        setAmount(data.jumlah + 1);
    });
    layanan.find('#minus').on('click', (e) => {
        setAmount(data.jumlah - 1);
    });
    amount.on('input', (e) => {
        setAmount(amount.val(), false);
    });
    tbody.append(layanan);
    $('#dataLayanan').DataTable();
    recalculate();
  });
});
</script>

@endpush

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
                                    <a class="btn btn-primary" title="Lihat pesanan" href="{{ route('order.view', ['pesanan' => $pesanan->id] )}}">
                                        <i class="fa fa-eye"></i>
                                    </a>
                                    <button class="btn btn-success" title="Tandai diambil" onclick="mark(this, {{ $pesanan->id }})">
                                        <i class="fa fa-check"></i>
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

const searchInput = $('form#search input[name=keyword]');
const tbody = $('#dataPesanan tbody')
searchInput.on('input', e => {
    const keyword = e.target.value;
    tbody.children().each((i, el) => {
        if(el.firstElementChild.textContent.match(new RegExp('^'+keyword, 'i'))) {
            el.classList.remove('d-none');
        } else {
            el.classList.add('d-none');
        }
    })
});

$(document).on('keydown', e => {
    let key = [];
    if(e.ctrlKey) key.push('ctrl');
    if(e.shiftKey) key.push('shift');
    if(e.altKey) key.push('alt');
    key.push(e.key);
    key = key.join('+')
    switch(key) {
        case '/':
            searchInput.select();
            break;
        default:
            return;
    }
    e.preventDefault();
});

function mark(el, id) {
    $(el.parentElement.parentElement).remove();
    showMessage(`Pesanan ${id} berhasil diambil`)
}
</script>
@endpush

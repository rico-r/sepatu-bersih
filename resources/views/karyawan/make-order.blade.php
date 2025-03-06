@extends('layout.dashboard-karyawan')

@section('title', 'Buat Pesanan')

@section('content')
<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Daftar Layanan</h1>
</div>

<div class="row">
    <div class="mb-4 col-xl-6">
        <div class="card shadow pe-2">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Daftar Layanan</h6>
            </div>
            <div class="card-body">
                <form id="search">
                    <div class="input-group">
                        <input name="keyword" type="text" class="form-control bg-light small" placeholder="Cari layanan..." autocomplete="off" title="Shortcut: / (SLASH)">
                        <div class="input-group-append">
                            <button class="btn btn-primary">
                                <i class="fas fa-search fa-sm"></i>
                            </button>
                        </div>
                    </div>
                </form>
                <div class="table-responsive mt-2">
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
                                    <input id="amount" type="number" width="0px" min="0">
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

    <div class="card shadow mb-4 col-xl-6">
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
            <button id="submit" class="btn btn-primary fw-bold w-100" title="shortcut: CTRL+ENTER">Submit</button>
        </div>
    </div>
</div>

<!-- Calc Returns Modal-->
<div class="modal fade" id="calcReturnsModal" tabindex="-1" role="dialog">
    <div class="modal-dialog my-auto" role="document">
        <form class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Kembalian</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="name">Total Bayar:</label>
                    <input type="text" class="form-control" id="total" name="total" readonly required>
                </div>
                <div class="form-group">
                    <label for="name">Uang:</label>
                    <input type="text" class="form-control" id="money" name="money" autocomplete="off" placeholder="Uang" required>
                </div>
                <div class="form-group">
                    <label for="name">Kembalian:</label>
                    <input type="text" class="form-control" id="returns" name="returns" autocomplete="off" readonly required>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
        </form>
    </div>
</div>

<!-- Print Modal-->
<div class="modal fade" id="printModal" tabindex="-1" role="dialog">
    <div class="modal-dialog my-auto" role="document">
        <form class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Cetak</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                Data berhasil disimpan
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" type="button" data-dismiss="modal">Tutup</button>
                <button type="button" class="btn btn-warning" onclick="printLabel(newId)">Cetak Label</button>
                <button type="button" class="btn btn-primary" onclick="printNota(newId)">Cetak Nota</button>
            </div>
        </form>
    </div>
</div>

@endsection

@push('styles')
    <link rel="stylesheet" href="/css/make-order.css">
@endpush

@push('scripts')
<script src="/js/print.js"></script>

<script>
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
const searchInput = $('form#search input[name=keyword]');
let total = 0;
let money = 0;
let returns = 0;
let newId = -1;

$('form#search').on('submit', e => {
    e.preventDefault();
    const amount = $('#dataLayanan tr:not(.d-none) #amount')
        .first();
    amount.val(parseInt(amount.val()) + 1)
        .select()
        .trigger('input');
    searchInput.val('').trigger('input');
});

const recalculate = (function() {
    const tbody = $('#nota > tbody');
    const rowEl = tbody.find('#row');
    const totalEl = tbody.find('#total');
    const submitButton = $('button#submit');
    return () => {
        tbody.children().remove();
        total = 0;
        let itemCount = 0;
        dataLayanan.forEach(data => {
            if(data.jumlah == 0) return;
            itemCount++;
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
        if(itemCount == 0) {
            submitButton.attr('disabled', true);
        } else {
            submitButton.removeAttr('disabled');
        }
    };
})();

function sendTransaction(e) {
    const list = [];
    dataLayanan.forEach((data) => {
        if(data.jumlah == 0) return;
        list.push({
            id: data.id,
            jumlah: data.jumlah,
            harga: data.harga,
        });
    });
    const request = {
        url: '{{ route('order.save') }}',
        method: "POST",
        dataType: "json",
        data: {
            kasir: {{ $user->id }},
            uang: money,
            kembalian: returns,
            list: list,
        }
    };
    request.success = (data, textStatus, xhr) => {
        newId = data.id;
        showPrint();
    };
    request.error = (xhr, textStatus, errorThrown) => {
        showMessage('Gagal menyimpan', 'danger');
    };
    $.ajax(request);
}

function resetAmount() {
    dataLayanan.forEach((data) => {
        data.jumlah = 0;
    });
    $('#dataLayanan #amount').each((i, el) => {
        $(el).val(0)
    })
    recalculate();
}

function showPrint() {
    $('#printModal').modal({ show: true });
    resetAmount();
}

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
    recalculate();
  });

  searchInput.on('input', e => {
    const keyword = e.target.value;
    tbody.children().each((i, el) => {
        if(el.textContent.match(new RegExp(keyword, 'i'))) {
            el.classList.remove('d-none');
        } else {
            el.classList.add('d-none');
        }
    })
  });
}).ready(function() {
    const calcReturnsModal = $('#calcReturnsModal');
    const moneyInput = calcReturnsModal.find('#money');
    const totalInput = calcReturnsModal.find('#total');
    const returnInput = calcReturnsModal.find('#returns');
    const submit = calcReturnsModal.find('[type=submit]');
    moneyInput.on('input', function() {
        money = parseInt(this.value);
        if(isNaN(money)) money = 0;
        returns = money - total;
        if(returns < 0) {
            returns = 0;
            submit.attr('disabled', true);
        } else {
            submit.removeAttr('disabled', true);
        }
        returnInput.val(formatMoney(returns));
    });
    $('button#submit').on('click', () => {
        calcReturnsModal.modal('show');
        totalInput.val(formatMoney(total));
        setTimeout(() => moneyInput.val(0).trigger('input').select(), 500)
    });
    calcReturnsModal.on('submit', e => {
        e.preventDefault();
        calcReturnsModal.modal('hide');
        sendTransaction();
    });
    calcReturnsModal.modal({ show: false });
}).on('keydown', e => {
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
        case 'ctrl+Enter':
            $('button#submit').trigger('click');
            break;
        default:
            return;
    }
    e.preventDefault();
});

</script>

@endpush

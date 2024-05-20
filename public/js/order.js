
const searchInput = $('form#search input[name=keyword]');
const tbody = $('#dataPesanan tbody')
searchInput.on('input', e => {
    const keyword = e.target.value;
    tbody.children().each((i, el) => {
        if (el.firstElementChild.textContent.match(new RegExp('^' + keyword, 'i'))) {
            el.classList.remove('d-none');
        } else {
            el.classList.add('d-none');
        }
    })
});

$(document).on('keydown', e => {
    let key = [];
    if (e.ctrlKey) key.push('ctrl');
    if (e.shiftKey) key.push('shift');
    if (e.altKey) key.push('alt');
    key.push(e.key);
    key = key.join('+')
    switch (key) {
        case '/':
            searchInput.select();
            break;
        default:
            return;
    }
    e.preventDefault();
});

function markDone(el, id) {
    $(el.parentElement.parentElement).remove();
    showMessage(`Pesanan ${id} berhasil diambil`)
}

function markReady(el, id) {
    const request = {
        url: ROUTE_MARK_READY.replace('##', id),
        method: "POST",
    };
    request.success = (data, textStatus, xhr) => {
        showMessage(`Pesanan ${id} berhasil diselesaikan`);
        $(el.parentElement.parentElement).remove();
    };
    request.error = (xhr, textStatus, errorThrown) => {
        showMessage(`Gagal menandai sebagai pesanan ${id} selesaikan`, 'danger');
    };
    $.ajax(request);
}

function deleteOrder(el, id) {
    if (!confirm(`Anda yakin ingin menghapus pesanan ${id}?`)) return;
    const request = {
        url: ROUTE_DELETE.replace('##', id),
        method: "GET",
    };
    request.success = (data, textStatus, xhr) => {
        showMessage(`Pesanan ${id} berhasil dihapus`);
        $(el.parentElement.parentElement).remove();
    };
    request.error = (xhr, textStatus, errorThrown) => {
        showMessage(`Gagal manghapus pesanan ${id}`, 'danger');
    };
    $.ajax(request);
}

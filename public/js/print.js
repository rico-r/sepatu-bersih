
/**
 * @param {Date} date 
 */
 function formatDatetime(date) {
  const month = ['Jan', 'Feb', 'Mar', "Apr", 'Mei', 'Jun', 'Jul', 'Ags', 'Sep', 'Okt', 'Nov', 'Des']
  return `${date.getDate()} ${month[date.getMonth()]} ${date.getFullYear()} ${date.getHours()}:${date.getMinutes()}`;
}

function printNota(idPesanan) {

  const request = {
    url: `/pesanan/${idPesanan}/json`,
  };
  request.success = (data, textStatus, xhr) => {
    printNotaReal(data)
  };
  request.error = (xhr, textStatus, errorThrown) => {
  };
  $.ajax(request);
}

function printNotaReal(data) {

  const printWindow = window.open('', '_blank');
  const content = [];
  const line = '<div>-------------------</div>';
  content.push(`
<html>
<head>
    <title>Cetak Nota</title>
    <style>
        @media print {
            body {
                -webkit-print-color-adjust: exact;
                font-size: 0.35cm;
            }
            .content {
                font-family: 'Courier New', Courier, monospace;
            }
            @page {
                margin: 0;
                size: 40mm auto;
            }
            * {
              line-height: 1.0;
            }
            body::before, body::after {
                content: none !important;
            }
            .title {
              font-weight: bold;
              font-size: 0.45cm;
              margin-left: 2.5mm;
              margin-bottom: 0.5cm;
            }
        }
    </style>
</head>
<body>
  <div class="content">
    <div class="title">Sepatu Bersih</div>
    <div>${formatDatetime(new Date(data.tgl))}</div>
    <div>Kasir: ${data.kasir}</div>
    <div>No. Pesanan : ${data.id}</div>
  `);
  content.push(line);
  for (const v of data.rincian) {
    content.push(`<div>${v.nama}</div>`);
    content.push(`<div>${v.jumlah}x ${tab('Rp ' + number_format(v.harga, 0, ',', '.'), 17 - v.jumlah.toString().length, '&nbsp;')}</div>`);
  }
  content.push(line);
  content.push(`<div>Total ${tab('Rp ' + number_format(data.total, 0, ',', '.'), 13, '&nbsp;')}</div>`);
  content.push(line);
  content.push(`<div>Uang ${tab('Rp ' + number_format(data.uang, 0, ',', '.'), 14, '&nbsp;')}</div>`);
  content.push(`<div>Kemb. ${tab('Rp ' + number_format(data.kembalian, 0, ',', '.'), 13, '&nbsp;')}</div>`);
  content.push(`
  </div>
  <script type="text/javascript">
    window.print();
    setTimeout(()=>window.close(),500);
  </script>
</body>
</html>
  `);
  printWindow.document.open();
  printWindow.document.write(content.join(''));
  printWindow.document.close();
}

function printLabel(idPesanan) {

  const request = {
    url: `/pesanan/${idPesanan}/json`,
  };
  request.success = (data, textStatus, xhr) => {
    printLabelReal(data)
  };
  request.error = (xhr, textStatus, errorThrown) => {
  };
  $.ajax(request);
}

function tab(txt, n, ch) {
  let result = txt;
  let count = n - txt.length
  for(let i = 0; i < count; i++) {
    result = ch + result;
  }
  return result;
}

function fmtNumber(n) {
  return tab(n, 2, '0');
}

function printLabelReal(data) {

  const printWindow = window.open('', '_blank');
  const content = [];
  content.push(`
<html>
<head>
    <title>Cetak Label</title>
    <style>
        @media print {
            body {
                -webkit-print-color-adjust: exact;
                font-size: 2cm;
            }
            .content {
            }
            @page {
                margin: 0;
                size: 40mm auto;
            }
            * {
              line-height: 1.0;
            }
            body::before, body::after {
                content: none !important;
            }
        }
    </style>
</head>
<body>
  <div class="content">
    <div style="margin-left: 5mm; font-weight: bold;">P${fmtNumber(data.id)}</div>
  <script type="text/javascript">
    window.print();
    setTimeout(()=>window.close(),500);
  </script>
</body>
</html>
  `);
  printWindow.document.open();
  printWindow.document.write(content.join(''));
  printWindow.document.close();
}

function number_format(number, decimals, dec_point, thousands_sep) {
  number = (number + '').replace(',', '').replace(' ', '');
  var n = !isFinite(+number) ? 0 : +number,
    prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
    sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep,
    dec = (typeof dec_point === 'undefined') ? '.' : dec_point,
    s = '',
    toFixedFix = function (n, prec) {
      var k = Math.pow(10, prec);
      return '' + Math.round(n * k) / k;
    };
  s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.');
  if (s[0].length > 3) {
    s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
  }
  if ((s[1] || '').length < prec) {
    s[1] = s[1] || '';
    s[1] += new Array(prec - s[1].length + 1).join('0');
  }
  return s.join(dec);
}


function printNota(idPesanan) {

  const request = {
    url: `/pesanan/${idPesanan}/json`,
  };
  request.success = (data, textStatus, xhr) => {
    console.log(data);
    printNotaReal(data)
  };
  request.error = (xhr, textStatus, errorThrown) => {
    // console.error(errorThrown)
  };
  $.ajax(request);
}

/**
 * @param {Date} date 
 */
function formatDatetime(date) {
  const month = ['Jan', 'Feb', 'Mar', "Apr", 'Mei', 'Jun', 'Jul', 'Ags', 'Sep', 'Okt', 'Nov', 'Des']
  return `${date.getDate()} ${month[date.getMonth()]} ${date.getFullYear()} ${date.getHours()}:${date.getMinutes()}:${date.getSeconds()}`;
}

function printNotaReal(data) {

  const printWindow = window.open('', '_blank');
  const content = [];
  const line = '<div>-------------------------</div>';
  content.push(`
<html>
<head>
    <title>Cetak Nota</title>
    <style>
        @media print {
            body {
                -webkit-print-color-adjust: exact;
            }
            .content {
                margin: 0.25cm;
                font-family: 'Courier New', Courier, monospace;
            }
            @page {
                margin: 0;
                size: 5.8cm 7cm;
            }
            * {
              line-height: 1.0;
            }
            body::before, body::after {
                content: none !important;
            }
            .title {
              text-align: center;
              font-weight: bold;
              font-size: 0.5cm;
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
    content.push(`<div>${v.jumlah}x &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Rp ${number_format(v.harga, 2, ',', '.')}</div>`);
  }
  content.push(line);
  content.push(`<div>Total &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Rp ${number_format(data.total, 2, ',', '.')}</div>`);
  content.push(line);
  content.push(`<div>Uang &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Rp ${number_format(data.uang, 2, ',', '.')}</div>`);
  content.push(`<div>Kembalian &nbsp; Rp ${number_format(data.kembalian, 2, ',', '.')}</div>`);
  content.push(line);
  content.push(`
  </div>
</body>
</html>
  `);
  printWindow.document.open();
  printWindow.document.write(content.join(''));
  printWindow.document.close();
  printWindow.onload = function () {
    printWindow.print();
    // printWindow.close();
  };
}

function number_format(number, decimals, dec_point, thousands_sep) {
  // *     example: number_format(1234.56, 2, ',', ' ');
  // *     return: '1 234,56'
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
  // Fix for IE parseFloat(0.55).toFixed(0) = 0;
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

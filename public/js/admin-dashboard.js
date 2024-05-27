const currentDate = new Date();
const pastDate = new Date();
pastDate.setDate(currentDate.getDate() - 30);

let myLineChart, myPieChart;
let printData;

const startDate = document.getElementById('startDate');
const endDate = document.getElementById('endDate');
const printReportButton = document.getElementById('printReport');
startDate.valueAsDate = pastDate;
endDate.valueAsDate = currentDate;
startDate.addEventListener('change', updateData);
endDate.addEventListener('change', updateData);

document.addEventListener('DOMContentLoaded', function () {
  updateData();
});

function updateData() {
  $.ajax({
    url: '/stat/month-revenue',
    method: "POST",
    dataType: "json",
    data: {
      start: startDate.value,
      end: endDate.value,
    },
    success: (data) => makeLineChart(data)
  });

  $.ajax({
    url: '/stat/service-type',
    method: "POST",
    dataType: "json",
    data: {
      start: startDate.value,
      end: endDate.value,
    },
    success: (data) => makePieChart(data)
  });

  printReportButton.disabled = true;
  $.ajax({
    url: '/stat/report',
    method: "POST",
    dataType: "json",
    data: {
      start: startDate.value,
      end: endDate.value,
    },
    success: (data) => {
      printData = data;
      console.log(data)
      printReportButton.removeAttribute('disabled')
    }
  });
}

Chart.defaults.global.defaultFontFamily = 'Nunito', '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
Chart.defaults.global.defaultFontColor = '#858796';

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

function makeLineChart(data) {
  const labels = [];
  const values = [];
  for (const v of data) {
    labels.push(v.date);
    values.push(parseInt(v.total));
  }
  var ctx = document.getElementById("myAreaChart");
  if (myLineChart) myLineChart.destroy();
  myLineChart = new Chart(ctx, {
    type: 'line',
    data: {
      labels: labels,
      datasets: [{
        label: "Pemasukan",
        lineTension: 0.3,
        backgroundColor: "rgba(78, 115, 223, 0.05)",
        borderColor: "rgba(78, 115, 223, 1)",
        pointRadius: 3,
        pointBackgroundColor: "rgba(78, 115, 223, 1)",
        pointBorderColor: "rgba(78, 115, 223, 1)",
        pointHoverRadius: 3,
        pointHoverBackgroundColor: "rgba(78, 115, 223, 1)",
        pointHoverBorderColor: "rgba(78, 115, 223, 1)",
        pointHitRadius: 10,
        pointBorderWidth: 2,
        data: values,
      }],
    },
    options: {
      maintainAspectRatio: false,
      layout: {
        padding: {
          left: 10,
          right: 25,
          top: 25,
          bottom: 0
        }
      },
      scales: {
        xAxes: [{
          time: {
            unit: 'date'
          },
          gridLines: {
            display: false,
            drawBorder: false
          },
          ticks: {
            maxTicksLimit: 7
          }
        }],
        yAxes: [{
          ticks: {
            maxTicksLimit: 5,
            padding: 10,
            // Include a dollar sign in the ticks
            callback: function (value, index, values) {
              return 'Rp ' + number_format(value, 2, ',', '.');
            }
          },
          gridLines: {
            color: "rgb(234, 236, 244)",
            zeroLineColor: "rgb(234, 236, 244)",
            drawBorder: false,
            borderDash: [2],
            zeroLineBorderDash: [2]
          }
        }],
      },
      legend: {
        display: false
      },
      tooltips: {
        backgroundColor: "rgb(255,255,255)",
        bodyFontColor: "#858796",
        titleMarginBottom: 10,
        titleFontColor: '#6e707e',
        titleFontSize: 14,
        borderColor: '#dddfeb',
        borderWidth: 1,
        xPadding: 15,
        yPadding: 15,
        displayColors: false,
        intersect: false,
        mode: 'index',
        caretPadding: 10,
        callbacks: {
          label: function (tooltipItem, chart) {
            var datasetLabel = chart.datasets[tooltipItem.datasetIndex].label || '';
            return datasetLabel + ': Rp ' + number_format(tooltipItem.yLabel, 2, ',', '.');
          }
        }
      }
    }
  });
}

function getRandomColor(rng) {
  function rand() {
    return Math.floor(rng() * 255);
  }
  const r = rand(), g = rand(), b = rand();
  return [
    `rgb(${r}, ${g}, ${b})`,
    `rgb(${Math.max(0, r - 60)}, ${Math.max(0, g - 60)}, ${Math.max(0, b - 60)})`,
  ];
}

function makePieChart(data) {
  const rng = sfc32('oifnaso8');
  const values = [];
  const labels = [];
  for (const v of data) {
    values.push(parseInt(v.jumlah));
    labels.push(v.nama);
  }
  const color = values.map(() => getRandomColor(rng))
  const color1 = color.map(v => v[0]);
  const color2 = color.map(v => v[1]);

  var ctx = document.getElementById("myPieChart");
  if (myPieChart) myPieChart.destroy();
  myPieChart = new Chart(ctx, {
    type: 'pie',
    data: {
      labels: labels,
      datasets: [{
        data: values,
        backgroundColor: color1,
        hoverBackgroundColor: color2,
        hoverBorderColor: "rgba(234, 236, 244, 1)",
      }],
    },
    options: {
      maintainAspectRatio: false,
      tooltips: {
        backgroundColor: "rgb(255,255,255)",
        bodyFontColor: "#858796",
        borderColor: '#dddfeb',
        borderWidth: 1,
        xPadding: 15,
        yPadding: 15,
        displayColors: false,
        caretPadding: 10,
      },
      cutoutPercentage: 80,
    },
  });
}

function printReport() {
  const printWindow = window.open('', '_blank');
  const content = [];
  content.push(`
<html>
<head>
    <title>Cetak Laporan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
        @media print {
            body {
                -webkit-print-color-adjust: exact;
            }
            .content {
                margin: 3cm;
            }
            @page {
                size: auto;
                margin: 0;
            }
            body::before, body::after {
                content: none !important;
            }
        }
    </style>
</head>
<body>
  <div class="content">
    <h1 class="text-center">Laporan Pemasukan - Sepatu Bersih</h1>
    <div class="text-center mb-3">${formatDate(startDate.valueAsDate)} s/d ${formatDate(endDate.valueAsDate)}</div>
    <table class="table table-bordered text-center">
      <thead>
        <tr>
          <th class="bg-secondary-subtle">No</th>
          <th class="bg-secondary-subtle">Tanggal</th>
          <th class="bg-secondary-subtle">Nama Layanan</th>
          <th class="bg-secondary-subtle">Jumlah</th>
          <th class="bg-secondary-subtle">Harga</th>
          <th class="bg-secondary-subtle">Subtotal</th>
        </tr>
      </thead>
    <tbody>
`);
  let total = 0;
  for (let i = 0; i < printData.length; i++) {
    const v = printData[i];
    total += parseInt(v.subtotal)
    content.push(`<tr>
      <td>${i + 1}</td>
      <td>${formatDate(new Date(v.date))}</td>
      <td>${v.nama}</td>
      <td>${v.jumlah}</td>
      <td class="text-end">Rp ${number_format(v.harga, 2, ',', '.')}</td>
      <td class="text-end">Rp ${number_format(v.subtotal, 2, ',', '.')}</td>
    </tr>`)
  }
  content.push(`
      <tr>
        <td colspan="5" class="fw-bold">Total</td>
        <td class="text-end">Rp ${number_format(total, 2, ',', '.')}</td>
      </tr>
    </tbody>
  </table>
  </div>
</body>
</html>
  `);
  printWindow.document.open();
  printWindow.document.write(content.join(''));
  printWindow.document.close();
  printWindow.onload = function () {
    printWindow.print();
    printWindow.close();
  };
}

/**
 * @param {Date} date 
 */
function formatDate(date) {
  const month = ['Jan', 'Feb', 'Mar', "Apr", 'Mei', 'Jun', 'Jul', 'Ags', 'Sep', 'Okt', 'Nov', 'Des']
  return `${date.getDate()} ${month[date.getMonth()]} ${date.getFullYear()}`;
}

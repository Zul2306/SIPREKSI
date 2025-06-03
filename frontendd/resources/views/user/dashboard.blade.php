@extends('layouts.home')

@section('content')
<div class="container py-4">
  <h4 class="text-center mb-4">📊 Statistik Prediksi</h4>

  <div class="row mb-4">
    <div class="col-md-5">
      <label for="startDate" class="form-label">Tanggal Mulai</label>
      <input type="date" id="startDate" class="form-control" />
    </div>
    <div class="col-md-5">
      <label for="endDate" class="form-label">Tanggal Akhir</label>
      <input type="date" id="endDate" class="form-control" />
    </div>
    <div class="col-md-2 d-flex align-items-end">
      <button class="btn btn-primary w-100" onclick="applyDateRange()">Terapkan</button>
    </div>
  </div>

  <div class="card shadow-sm rounded-4 p-4">
    <canvas id="simpleChart" style="height: 300px;"></canvas>
    <div id="noDataMessage" class="text-center text-muted mt-3" style="display: none;">
      Tidak ada data untuk rentang waktu ini.
    </div>
  </div>
</div>
<!-- Modal Detail -->
<div class="modal fade" id="detailModal" tabindex="-1" aria-labelledby="detailModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Detail Prediksi</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <div id="modalContent">Memuat data...</div>
        </div>
      </div>
    </div>
  </div>
  

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
  const userId = {{ $userId }};
  let chart;

  function applyDateRange() {
    const startDate = document.getElementById('startDate').value;
    const endDate = document.getElementById('endDate').value;

    if (!startDate || !endDate || startDate > endDate) {
      alert('Silakan pilih rentang tanggal yang valid.');
      return;
    }

    fetch(`/user/dashboard/id/${userId}?start=${startDate}&end=${endDate}`)

      .then(res => res.json())
      .then(data => {
        const chartCanvas = document.getElementById('simpleChart');
        const noDataMsg = document.getElementById('noDataMessage');

        if (!data.length) {
          chartCanvas.style.display = 'none';
          noDataMsg.style.display = 'block';
          noDataMsg.textContent = 'Tidak ada data untuk rentang waktu ini.';
          if (chart) chart.destroy();
          return;
        }

        const labels = data.map(item => item.date);
        const values = data.map(item => parseFloat(item.result));

        chartCanvas.style.display = 'block';
        noDataMsg.style.display = 'none';

        if (chart) chart.destroy();
        const ctx = chartCanvas.getContext('2d');
        chart = new Chart(ctx, {
          type: 'line',
          data: {
            labels: labels,
            datasets: [{
              label: 'Rata-rata Hasil Prediksi (%)',
              data: values,
              backgroundColor: 'rgba(75, 192, 192, 0.2)',
              borderColor: 'rgba(75, 192, 192, 1)',
              borderWidth: 2,
              pointBackgroundColor: 'rgba(54, 162, 235, 1)',
              pointRadius: 4,
              pointHoverRadius: 6,
              fill: true,
              tension: 0.4
            }]
          },
          options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
              y: {
                min: 0,
                max: 100,
                ticks: {
                  stepSize: 25,
                  callback: value => `${value}%`
                },
                title: {
                  display: true,
                  text: 'Persentase (%)',
                  font: { size: 14 }
                },
                grid: {
                  color: 'rgba(200,200,200,0.2)',
                  borderDash: [5, 5]
                }
              },
              x: {
                title: {
                  display: true,
                  text: 'Tanggal',
                  font: { size: 14 }
                },
                grid: {
                  display: false
                }
              }
            },
            plugins: {
              tooltip: {
                callbacks: {
                  label: context => `Hasil: ${context.parsed.y}%`
                }
              },
              legend: {
                display: true
              }
            }
          }
        });
      })
      .catch(err => {
        console.error('Gagal memuat data:', err);
        const msg = document.getElementById('noDataMessage');
        msg.textContent = 'Terjadi kesalahan saat memuat data.';
        msg.style.display = 'block';
        document.getElementById('simpleChart').style.display = 'none';
        if (chart) chart.destroy();
      });
  }
  document.addEventListener('DOMContentLoaded', function () {
  const ctx = document.getElementById('simpleChart');
  ctx.onclick = function (evt) {
    const points = chart.getElementsAtEventForMode(evt, 'nearest', { intersect: true }, true);
    if (points.length) {
      const index = points[0].index;
      const clickedDate = chart.data.labels[index];

      fetch(`/user/dashboard/details?user_id=${userId}&date=${clickedDate}`)
        .then(res => res.json())
        .then(data => {
          const container = document.getElementById('modalContent');
          if (data.length === 0) {
            container.innerHTML = "<p class='text-muted'>Tidak ada data untuk tanggal ini.</p>";
          } else {
            container.innerHTML = data.map(item => `
              <ul class="list-group">
                <li class="list-group-item"><strong>Rata-rata:</strong> ${item.rata_rata}</li>
                <li class="list-group-item"><strong>MAT:</strong> ${item.mat}</li>
                <li class="list-group-item"><strong>BIO:</strong> ${item.bio}</li>
                <li class="list-group-item"><strong>KIM:</strong> ${item.kim}</li>
                <li class="list-group-item"><strong>BIG:</strong> ${item.big}</li>
               
                <li class="list-group-item"><strong>Certificate Score:</strong> ${item.certificate_score}</li>
              </ul>
              <hr/>
            `).join('');
          }

          const modal = new bootstrap.Modal(document.getElementById('detailModal'));
          modal.show();
        });
    }
  };
});

</script>
@endsection

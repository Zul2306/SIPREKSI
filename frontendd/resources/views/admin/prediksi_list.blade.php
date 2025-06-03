@extends('layouts.home')

@section('content')
<div class="container">
    <h1 class="my-4">Daftar User - {{ $kelas->nama ?? 'Kelas ' . $kelas->nama_kelas }}</h1>

    @if(isset($users) && $users->isNotEmpty())
    <div class="table-responsive">
      <table class="table table-light mb-0">
          <thead>
              <tr>
                  <th>ID</th>
                  <th>NAME</th>
                  <th>ACTION</th>
              </tr>
          </thead>
          <tbody>
            @foreach($users as $index => $user)
              <tr>
                <td>{{ $index + 1 }}</td>
                  <td> {{ $user->name }} </td>
                 
                  <td>
                      <!-- Tombol Trigger Modal -->
                      <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $user->id }}">
                          Hapus
                      </button>
  
                      <!-- Modal -->
                      <div class="modal fade" id="deleteModal{{ $user->id }}" tabindex="-1" aria-labelledby="modalLabel{{ $user->id }}" aria-hidden="true">
                          <div class="modal-dialog">
                              <form action="{{ route('admin.destroy', $user->id) }}" method="POST">
                                  @csrf
                                  @method('DELETE')
                                  <div class="modal-content">
                                      <div class="modal-header">
                                          <h5 class="modal-title" id="modalLabel{{ $user->id }}">Konfirmasi Hapus</h5>
                                          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                      </div>
                                      <div class="modal-body">
                                          Apakah Anda yakin ingin menghapus user <strong>{{ $user->name }}</strong>?
                                      </div>
                                      <div class="modal-footer">
                                          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                          <button type="submit" class="btn btn-danger">Hapus</button>
                                      </div>
                                  </div>
                              </form>
                          </div>
                      </div>
                      <button class="btn btn-primary" data-user-id="{{ $user->id }}" data-bs-toggle="modal" data-bs-target="#chartModal">
                        Lihat Grafik
                    </button>
                    <div class="modal fade" id="chartModal" tabindex="-1" aria-labelledby="chartModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                          <div class="modal-content">
                            <div class="modal-header">
                              <h5 class="modal-title">Grafik Hasil Prediksi {{ $user->name }}</h5>
                              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                            </div>
                            <div class="modal-body">
                              <canvas id="predictionChart" width="400" height="200"></canvas>
                            </div>
                          </div>
                        </div>
                      </div>
                      
                    
                  </td>
              </tr>
              @endforeach
          </tbody>
      </table>
  </div>
    @else
        <p>Tidak ada user dalam kelas ini.</p>
    @endif
</div>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    let chartInstance = null;

    document.addEventListener('DOMContentLoaded', function () {
        const chartModal = document.getElementById('chartModal');

        chartModal.addEventListener('show.bs.modal', function (event) {
            const button = event.relatedTarget;
            const userId = button.getAttribute('data-user-id');

            fetch(`/prediction/chart-data/user/${userId}`)
                .then(response => response.json())
                .then(data => {
                    const labels = data.map(item => item.created_at);
const results = data.map(item => item.result);

const ctx = document.getElementById('predictionChart').getContext('2d');

if (chartInstance) chartInstance.destroy();

chartInstance = new Chart(ctx, {
    type: 'line',
    data: {
        labels: labels,
        datasets: [{
            label: 'Hasil (%)',
            data: results,
            backgroundColor: 'rgba(54, 162, 235, 0.2)',
            borderColor: 'rgba(54, 162, 235, 1)',
            borderWidth: 2,
            fill: true,
            tension: 0.3,
        }]
    },
    options: {
        scales: {
            y: {
                beginAtZero: true,
                max: 100,
                ticks: {
                    stepSize: 10,
                    callback: function(value) {
                        return value + '%';
                    }
                }
            }
        },
        plugins: {
            tooltip: {
                callbacks: {
                    label: function(context) {
                        return `${context.raw}%`;
                    }
                }
            }
        }
    }
});

                });
        });
    });
</script>

@endsection

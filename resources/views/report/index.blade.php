@extends('layout.master')

@section('content')
    <div class="main-panel">
        <div class="content">
            <div class="panel-header"
                style="background-image: linear-gradient(to right, #6C81C6 0%, #6C81C6 40%, #3f59ae 100%);">
                <div class="page-inner py-5 text-center">
                    <h2 class="text-white pb-2 fw-bold">Report Traffic</h2>
                    <h5 class="text-white op-7 mb-2">Total Slot Data: <span id="totalData">{{ $report->count() }}</span></h5>
                </div>
            </div>

            <div class="page-inner mt--5">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <canvas id="trafficChart" height="100"></canvas>

                            <form action="{{ route('report.index') }}" method="GET" class="text-center mt-4">
                                <label><b>Tanggal:</b></label>
                                <input type="date" name="tgl_awl" value="{{ $tgl_awl }}" required>
                                <button class="btn btn-primary">Cari</button>
                            </form>

                            <div class="text-center mt-3" id="viewTgl">{{ $view_tgl }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        let trafficChart;

        function fetchTrafficData() {
            fetch("{{ route('report.json') }}?tgl_awl={{ $tgl_awl }}")
                .then(res => res.json())
                .then(data => {
                    const labels = [];
                    for (let i = 1; i <= 24; i++) {
                        labels.push((i < 10 ? '0' + i : i) + ':00');
                    }

                    const trafficMap = {};
                    data.forEach(item => {
                        const hour = item.waktu.substr(11, 5);
                        trafficMap[hour] = item.avg_traffic;
                    });

                    const avgTraffic = labels.map(hour => trafficMap[hour] || 0);

                    if (trafficChart) {
                        trafficChart.data.labels = labels;
                        trafficChart.data.datasets[0].data = avgTraffic;
                        trafficChart.update();
                    } else {
                        const ctx = document.getElementById('trafficChart').getContext('2d');
                        trafficChart = new Chart(ctx, {
                            type: 'line',
                            data: {
                                labels: labels,
                                datasets: [{
                                    label: 'Rata-rata Bandwidth (Mbps)',
                                    data: avgTraffic,
                                    borderColor: 'blue',
                                    backgroundColor: 'rgba(54, 162, 235, 0.2)',
                                    tension: 0.3,
                                    fill: true
                                }]
                            },
                            options: {
                                responsive: true,
                                plugins: {
                                    title: {
                                        display: true,
                                        text: 'Grafik Trafik Harian per Jam'
                                    }
                                },
                                scales: {
                                    y: {
                                        beginAtZero: true,
                                        title: {
                                            display: true,
                                            text: 'Mbps'
                                        }
                                    }
                                }
                            }
                        });
                    }

                    document.getElementById('totalData').innerText = data.length;
                });
        }

        fetchTrafficData();
        setInterval(fetchTrafficData, 60000); // refresh tiap 1 menit

        // Trigger penyimpanan data setiap menit (pakai scheduler/cron di sisi server lebih baik)
        setInterval(() => {
            fetch('{{ route('report.store') }}')
                .then(res => res.json())
                .then(data => console.log(data));
        }, 60000);
    </script>
@endsection

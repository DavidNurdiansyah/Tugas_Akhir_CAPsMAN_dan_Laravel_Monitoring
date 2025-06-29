{{-- @extends('layout.master')

@section('content')
    <div class="main-panel">
        <div class="content">
            <div class="panel-header"
                style="background-image: linear-gradient(to right, #6C81C6 0%, #6C81C6 40%, #3f59ae 100%);">
                <div class="page-inner py-5">
                    <div class="d-flex justify-content-center">
                        <div>
                            <h2 class="text-white pb-2 fw-bold">Report UP & Down</h2>
                        </div>
                    </div>
                    <h5 class="text-white op-7 mb-2">Total Report : {{ $report->count() }}</h5>
                </div>
            </div>
            <div class="page-inner mt--5">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <center>
                                <div>
                                    <table>
                                        <tr>
                                            <form class="form-inline" action="{{ route('report.index') }}" method="GET">
                                                <div class="form-group">
                                                    <td><label><b>Mulai Tanggal:</b></label></td>
                                                    <td><input type="date" class="form-control datepicker" name="tgl_awl"
                                                            id="tgl_awl" value="{{ date('Y-m-d') }}" required></td>
                                                </div>

                                                <div class="form-group">
                                                    <td><label><b>Sampai Tanggal:</b></label></td>
                                                    <td><input type="date" class="form-control datepiscker"
                                                            name="tgl_akhr" id="tgl_akhr" value="{{ date('Y-m-d') }}"
                                                            required></td>
                                                </div>

                                                <div class="form-group">
                                                    <td><button type="submit" class="btn btn-primary">Search</button>
                                                    </td>
                                                </div>
                                                <div class="form-group">
                                                    <td><a href="{{ route('report.index') }}" type="reset" value="reset"
                                                            class="btn btn-danger">Reset</a></td>
                                                </div>
                                            </form>
                                        </tr>
                                    </table>
                                </div>
                            </center>
                            <center class="mt-4">
                                {{ $view_tgl }}
                            </center>
                            <div class="table-responsive">
                                <table id="reportTable" class="display table table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Status</th>
                                            <th>Date/Time</th>

                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>No</th>
                                            <th>Status</th>
                                            <th>Date/Time</th>

                                        </tr>
                                    </tfoot>
                                    <tbody id="reportTable">
                                        @foreach ($report as $no => $data)
                                            <tr>
                                                <div hidden>{{ $id = str_replace('*', '', $data['.id']) }}</div>
                                                <td>{{ $no + 1 }} </td>
                                                <td>
                                                    @if (str_contains($data['text'], 'Melebihi'))
                                                        <span style="color: red;">{{ $data['text'] }}</span>
                                                    @else
                                                        <span style="color: black;">{{ $data['text'] }}</span>
                                                    @endif
                                                </td>

                                                <td>{{ date('d F Y H:i:s', strtotime($data['created_at'])) }} </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="d-flex justify-content-between mt-3">
                                <button id="prevBtn" class="btn btn-secondary">Previous</button>
                                <button id="nextBtn" class="btn btn-secondary">Next</button>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const rows = Array.from(document.querySelectorAll("#reportTable tbody tr")); // Pastikan id-nya sesuai
            const prevBtn = document.getElementById("prevBtn");
            const nextBtn = document.getElementById("nextBtn");

            let currentPage = 1;
            const rowsPerPage = 5; // Ganti sesuai kebutuhan

            function renderTable() {
                // Sembunyikan semua baris terlebih dahulu
                rows.forEach(row => row.style.display = "none");

                const start = (currentPage - 1) * rowsPerPage;
                const end = start + rowsPerPage;

                rows.slice(start, end).forEach(row => {
                    row.style.display = "";
                });

                prevBtn.disabled = currentPage === 1;
                nextBtn.disabled = end >= rows.length;
            }

            prevBtn.addEventListener("click", () => {
                if (currentPage > 1) {
                    currentPage--;
                    renderTable();
                }
            });

            nextBtn.addEventListener("click", () => {
                if (currentPage * rowsPerPage < rows.length) {
                    currentPage++;
                    renderTable();
                }
            });

            renderTable(); // Panggil saat halaman dimuat
        });
    </script>
@endsection --}}


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

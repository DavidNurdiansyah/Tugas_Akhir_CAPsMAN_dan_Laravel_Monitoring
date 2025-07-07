@extends('layout.master')

@section('content')
    <div class="main-panel">
        <div class="content">
            <div class="panel-header"
                style="background-image: linear-gradient(to right, #6C81C6 0%, #6C81C6 40%, #3f59ae 100%);">
                <div class="page-inner py-5">
                    <div class="d-flex justify-content-center">
                        <div>
                            <h2 class="text-white pb-2 fw-bold text-center">Status AP</h2>
                        </div>
                    </div>
                </div>
            </div>

            <div class="page-inner mt--5">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">

                            <!-- Search Bar -->
                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <input type="text" id="searchAP" class="form-control rounded"
                                        placeholder="Cari Nama AP...">
                                </div>
                            </div>

                            <!-- Tabel Status -->
                            <div class="table-responsive">
                                <table id="add-row" class="display table table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Nama</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>No</th>
                                            <th>Nama</th>
                                            <th>Status</th>
                                        </tr>
                                    </tfoot>
                                    <tbody id="status-table-body">
                                        @foreach ($AP as $no => $data)
                                            <tr>
                                                <div hidden>{{ $id = str_replace('*', '', $data['.id']) }}</div>
                                                <td>{{ $no + 1 }}</td>
                                                <td>{{ $data['name'] ?? '' }}</td>
                                                <td>
                                                    @php
                                                        $isOnline = false;
                                                        foreach ($status as $st) {
                                                            if (
                                                                isset($st['identity']) &&
                                                                trim($st['identity']) === trim($data['name'])
                                                            ) {
                                                                $isOnline =
                                                                    isset($st['state']) &&
                                                                    strtolower($st['state']) === 'run';
                                                                break;
                                                            }
                                                        }
                                                    @endphp
                                                    @if ($isOnline)
                                                        <span class="text-success">Online</span>
                                                    @else
                                                        <span class="text-danger">Offline</span>
                                                    @endif
                                                </td>

                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <!-- Pagination Buttons -->
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

    <!-- JQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- JavaScript: Search, Pagination, dan Auto Update -->
    <script>
        let currentPage = 1;
        const rowsPerPage = 3;
        let filteredRows = [];

        function applySearchAndPagination() {
            const query = document.getElementById("searchAP").value.toLowerCase();
            const allRows = Array.from(document.querySelectorAll("#status-table-body tr"));

            filteredRows = allRows.filter(row => {
                const cell = row.cells[1];
                return cell && cell.textContent.toLowerCase().includes(query);
            });

            allRows.forEach(row => row.style.display = "none");

            const start = (currentPage - 1) * rowsPerPage;
            const end = start + rowsPerPage;
            filteredRows.slice(start, end).forEach(row => row.style.display = "");

            document.getElementById("prevBtn").disabled = currentPage === 1;
            document.getElementById("nextBtn").disabled = end >= filteredRows.length;
        }

        document.addEventListener("DOMContentLoaded", function() {
            document.getElementById("searchAP").addEventListener("input", function() {
                currentPage = 1;
                applySearchAndPagination();
            });

            document.getElementById("prevBtn").addEventListener("click", function() {
                if (currentPage > 1) {
                    currentPage--;
                    applySearchAndPagination();
                }
            });

            document.getElementById("nextBtn").addEventListener("click", function() {
                if (currentPage * rowsPerPage < filteredRows.length) {
                    currentPage++;
                    applySearchAndPagination();
                }
            });

            applySearchAndPagination();
        });

        function updateStatus() {
            $.get('{{ route('statusap.status') }}', function(response) {
                const newBody = $(response).find('#status-table-body').html();
                $('#status-table-body').html(newBody);
                applySearchAndPagination();
            });
        }

        setInterval(updateStatus, 6000);
    </script>
@endsection

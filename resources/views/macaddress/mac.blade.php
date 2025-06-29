@extends('layout.master')

@section('content')
    <div class="main-panel">
        <div class="content">
            <div class="panel-header"
                style="background-image: linear-gradient(to right, #6C81C6 0%, #6C81C6 40%, #3f59ae 100%);">
                <div class="page-inner py-5">
                    <div class="d-flex justify-content-center">
                        <div>
                            <h2 class="text-white pb-2 fw-bold text-center">MAC ADDRESS</h2>
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
                                    <input type="text" id="searchMac" class="form-control rounded"
                                        placeholder="Cari MAC Address...">
                                </div>
                            </div>

                            <!-- Modal Add (optional if needed) -->
                            <div class="modal fade" id="addRowModal" tabindex="-1" role="dialog" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <!-- Tambahkan isi modal jika perlu -->
                                    </div>
                                </div>
                            </div>

                            <!-- Table -->
                            <div class="table-responsive">
                                <table id="macTable" class="display table table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Nama</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>No</th>
                                            <th>Nama</th>
                                            <th>Action</th>
                                        </tr>
                                    </tfoot>
                                    <tbody id="macTableBody">
                                        @foreach ($name as $no => $data)
                                            @if (!empty($data['mac-address']))
                                                <tr>
                                                    <div hidden>{{ $id = str_replace('*', '', $data['.id']) }}</div>
                                                    <td>{{ $no + 1 }}</td>
                                                    <td>{{ $data['mac-address'] }}</td>
                                                    <td>
                                                        <div class="form-button-action">
                                                            <a href="{{ route('macaddress.delete', $id) }}" type="button"
                                                                data-toggle="tooltip" class="btn btn-link btn-danger"
                                                                data-original-title="Remove"
                                                                onclick="return confirm('Apakah anda yakin menghapus Mac {{ $data['mac-address'] }} ?')">
                                                                <i class="fa fa-trash"></i>
                                                            </a>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endif
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
    <!-- JavaScript Pagination + Search -->
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const rows = Array.from(document.querySelectorAll("#macTable tbody tr"));
            const searchInput = document.getElementById("searchMac");
            const prevBtn = document.getElementById("prevBtn");
            const nextBtn = document.getElementById("nextBtn");

            let currentPage = 1;
            const rowsPerPage = 5;
            let filteredRows = [...rows];

            function renderTable() {
                // Hide all
                rows.forEach(row => row.style.display = "none");

                const start = (currentPage - 1) * rowsPerPage;
                const end = start + rowsPerPage;

                filteredRows.slice(start, end).forEach(row => {
                    row.style.display = "";
                });

                prevBtn.disabled = currentPage === 1;
                nextBtn.disabled = end >= filteredRows.length;
            }

            function filterRows() {
                const search = searchInput.value.toLowerCase();
                filteredRows = rows.filter(row => {
                    const cell = row.cells[1];
                    return cell && cell.textContent.toLowerCase().includes(search);
                });
                currentPage = 1;
                renderTable();
            }

            searchInput.addEventListener("input", filterRows);
            prevBtn.addEventListener("click", () => {
                if (currentPage > 1) {
                    currentPage--;
                    renderTable();
                }
            });
            nextBtn.addEventListener("click", () => {
                if (currentPage * rowsPerPage < filteredRows.length) {
                    currentPage++;
                    renderTable();
                }
            });

            renderTable(); // Initial render
        });
    </script>
@endsection

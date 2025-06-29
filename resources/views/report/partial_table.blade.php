{{-- <table class="table table-striped">
    <thead>
        <tr>
            <th>No</th>
            <th>Waktu</th>
            <th>Status Up</th>
            <th>Status Down</th>
            <th>Rata-rata Mbps</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($report as $no => $data)
            <tr>
                <td>{{ $no + 1 }}</td>
                <td>{{ $data->waktu }}</td>
                <td>{{ $data->up }}</td>
                <td>{{ $data->down }}</td>
                <td>
                    @if ($data->avg_traffic > 50)
                        <span style="color:red;">{{ $data->avg_traffic }} Mbps</span>
                    @else
                        <span>{{ $data->avg_traffic }} Mbps</span>
                    @endif
                </td>
            </tr>
        @endforeach
    </tbody>
</table> --}}

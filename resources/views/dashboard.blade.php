@extends('layout.master')

@section('content')
    <div class="main-panel">
        <div class="content">
            <div class="page-inner mt-1">
                <div class="row justify-content-center">
                    <div class="col-md-8">
                        <div class="card mx-auto" style="width: 100%; max-width: 1000px;">
                            <div class="form-group">
                                <label for="interface">Select AP</label>
                                <select class="form-control" name="interface" id="interface">
                                    @foreach ($cap as $data)
                                        <option value="{{ $data['name'] }}">{{ $data['name'] }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="card-body">
                                <div id="trafficChart" style="width: 100%; height: 250px;"></div>
                            </div>
                            <div class="form-group" id="traffic"></div>
                            <div class="form-group">
                                {{-- Jumlah Access Point : # <br>
                                Access Point Online : # --}}
                                Jumlah Access Point : {{ $totalap }} <br>
                                Access Point Online : {{ $status }}


                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- footer --}}
        {{-- @include('layout.footer') --}}
    </div>
    <div id="response-wrapper" style="display:none;"></div>


    <!-- Load Plotly.js -->
    <script src="https://cdn.plot.ly/plotly-2.30.0.min.js"></script>


    <!-- JQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        var rxData = [];
        var txData = [];
        var timeData = [];

        // Inisialisasi grafik pertama kali
        Plotly.newPlot('trafficChart', [{
            x: timeData,
            y: rxData,
            mode: 'lines',
            name: 'RX',
            line: {
                color: 'blue'
            }
        }, {
            x: timeData,
            y: txData,
            mode: 'lines',
            name: 'TX',
            line: {
                color: 'red'
            }
        }], {
            title: 'Traffic Monitoring',
            xaxis: {
                title: 'Waktu'
            },
            yaxis: {
                title: 'bps (bits per second)'
            }
        });
        console.log("Plotly initialized", timeData, rxData, txData);


        setInterval(traffic, 1000); // Update setiap 1 detik


        function traffic() {
            var traffic = $('#interface').val();
            var url = '{{ route('dashboard.traffic', ':traffic') }}';
            var fullUrl = url.replace(':traffic', traffic);

            $.get(fullUrl, function(response) {
                try {
                    // TEMPATKAN response ke dalam div dummy
                    $('#response-wrapper').html(response);

                    var rx = $('#response-wrapper').find('#rx').text().trim();
                    var tx = $('#response-wrapper').find('#tx').text().trim();

                    console.log("RX Text:", rx, "TX Text:", tx);

                    var rxInt = parseInt(rx);
                    var txInt = parseInt(tx);

                    if (isNaN(rxInt) || isNaN(txInt)) {
                        console.warn("RX/TX bukan angka!", rx, tx);
                        return;
                    }

                    var now = new Date();
                    var timeLabel = now.getHours() + ":" + now.getMinutes() + ":" + now.getSeconds();

                    timeData.push(timeLabel);
                    rxData.push(rxInt);
                    txData.push(txInt);

                    if (timeData.length > 30) {
                        timeData.shift();
                        rxData.shift();
                        txData.shift();
                    }

                    Plotly.update('trafficChart', {
                        x: [timeData, timeData],
                        y: [rxData, txData]
                    });

                    // Update tampilan
                    $('#traffic').html(response);

                } catch (error) {
                    console.error('Error parsing traffic data:', error);
                }
            });
        }
    </script>
@endsection

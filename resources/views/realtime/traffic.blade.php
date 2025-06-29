@php
    function formatBytes($bytes, $decimal = 2)
    {
        $satuan = ['Bytes', 'Kb', 'Mb', 'Gb', 'Tb'];
        $i = 0;
        while ($bytes >= 1024 && $i < count($satuan) - 1) {
            $bytes /= 1024;
            $i++;
        }
        return round($bytes, $decimal) . ' ' . $satuan[$i];
    }
@endphp

<!-- Data buat JavaScript -->
<div id="rx" style="display:none;">{{ $rx }}</div>
<div id="tx" style="display:none;">{{ $tx }}</div>



<!-- Tampilan untuk user -->
<strong>Status Traffic Upload (TX):</strong> {{ formatBytes($tx) }} <br>
<strong>Status Traffic Download (RX):</strong> {{ formatBytes($rx) }}

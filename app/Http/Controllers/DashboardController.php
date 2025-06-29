<?php

namespace App\Http\Controllers;

use App\Models\Report;
use App\Models\RouterosAPI;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class DashboardController extends Controller
{
    public function index()
    {
        $ip = session()->get('ip');
        $user = session()->get('username');
        $pw = session()->get('password');
        $API = new RouterosAPI();
        $API->debug('false');

        if ($API->connect($ip, $user, $pw)) {
            $cap = $API->comm('/caps-man/interface/print');
            $status = $API->comm('/caps-man/remote-cap/print');

            $data = [
                'cap' => $cap,
                'totalap' => count($cap),
                'status' => count($status)
            ];

            return view('dashboard', $data);
        } else {
            return redirect('failed');
        }
        // return view('dashboard');
    }



    public function traffic($traffic)
    {
        $ip = session()->get('ip');
        $user = session()->get('username');
        $password = session()->get('password');
        $API = new RouterosAPI();
        $API->debug = false;

        if ($API->connect($ip, $user, $password)) {
            $trafficData = $API->comm('/interface/monitor-traffic', [
                'interface' => $traffic,
                'once' => '',
            ]);

            if (empty($trafficData)) {
                return "Interface tidak ditemukan atau tidak ada data.";
            }

            $rx = $trafficData[0]['rx-bits-per-second'] ?? 0;
            $tx = $trafficData[0]['tx-bits-per-second'] ?? 0;

            return view('realtime.traffic', [
                'rx' => $rx,
                'tx' => $tx,
                'interface' => $traffic,
            ]);
        } else {
            return 'Koneksi Gagal';
        }
    }
}
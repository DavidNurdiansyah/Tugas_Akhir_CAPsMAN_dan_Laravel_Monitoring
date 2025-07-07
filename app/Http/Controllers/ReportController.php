<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Report;
use App\Models\RouterosAPI;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class ReportController extends Controller
{
    public function index(Request $request)
    {
        $tgl_awl = $request->tgl_awl ?? date('Y-m-d');

        $report = DB::table('reports')
            ->select(
                DB::raw("FROM_UNIXTIME(FLOOR(UNIX_TIMESTAMP(created_at)/3600)*3600) as waktu"),
                DB::raw("ROUND(AVG(bandwidth), 2) as avg_traffic")
            )
            ->whereBetween('created_at', [$tgl_awl . ' 00:00:00', $tgl_awl . ' 23:59:59'])
            ->groupBy(DB::raw("FROM_UNIXTIME(FLOOR(UNIX_TIMESTAMP(created_at)/3600)*3600)"))
            ->orderBy(DB::raw("waktu"), 'asc')
            ->get();

        $view_tgl = "Data Tanggal : $tgl_awl";

        return view('report.index', compact('report', 'view_tgl', 'tgl_awl'));
    }

    public function json(Request $request)
    {
        $tgl_awl = $request->tgl_awl ?? date('Y-m-d');

        $report = DB::table('reports')
            ->select(
                DB::raw("FROM_UNIXTIME(FLOOR(UNIX_TIMESTAMP(created_at)/3600)*3600) as waktu"),
                DB::raw("ROUND(AVG(bandwidth), 2) as avg_traffic")
            )
            ->whereBetween('created_at', [$tgl_awl . ' 00:00:00', $tgl_awl . ' 23:59:59'])
            ->groupBy(DB::raw("FROM_UNIXTIME(FLOOR(UNIX_TIMESTAMP(created_at)/3600)*3600)"))
            ->orderBy(DB::raw("waktu"), 'asc')
            ->get();

        return response()->json($report);
    }

    public function storeTraffic()
    {
        $ip = session()->get('ip');
        $user = session()->get('username');
        $pw = session()->get('password');
        $API = new RouterosAPI();
        $API->debug = false;

        if ($API->connect($ip, $user, $pw)) {
            $API->write("/interface/monitor-traffic", false);
            $API->write("=interface=bridge1", false);
            $API->write("=once=");
            $result = $API->read();
            $API->disconnect();

            if (isset($result[0]['rx-bits-per-second']) && isset($result[0]['tx-bits-per-second'])) {
                $total_bps = $result[0]['rx-bits-per-second'] + $result[0]['tx-bits-per-second'];
                $total_mbps = round($total_bps / 1000000, 2);

                $latest = Report::orderByDesc('created_at')->first();



                if (!$latest || Carbon::parse($latest->created_at)->lt(now()->subMinutes(30))) {
                    Report::create([
                        'bandwidth' => $total_mbps,
                        'text' => 'Data bandwidth',
                        'created_at' => now(),
                        'updated_at' => now()
                    ]);
                }


                return response()->json(['mbps' => $total_mbps]);
            }
        }

        return response()->json(['message' => 'Gagal ambil trafik'], 500);
    }
}
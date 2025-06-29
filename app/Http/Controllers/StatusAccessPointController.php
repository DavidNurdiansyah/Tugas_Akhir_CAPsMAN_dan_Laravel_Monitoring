<?php

namespace App\Http\Controllers;

use App\Models\RouterosAPI;
use Illuminate\Http\Request;

class StatusAccessPointController extends Controller
{
    public function index()
    {
        $ip = session()->get('ip');
        $user = session()->get('username');
        $pw = session()->get('password');
        $API = new RouterosAPI();
        $API->debug('false');

        if ($API->connect($ip, $user, $pw)) {
            $AP = $API->comm('/caps-man/interface/print');
            $status = $API->comm('/caps-man/remote-cap/print');

            $data = [
                'AP' => $AP,
                'status' => $status
            ];
            // dd($AP, $status);

            return view('statusap.status', $data);
        } else {
            return redirect()->route('failed');
        }
        // return view('statusap.status');
    }
}